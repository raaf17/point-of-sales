<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $member = Member::count();
        $pendapatan = DB::table('penjualan')
            ->selectRaw("SUM(bayar) as total_pendapatan")
            ->get()
            ->pluck('total_pendapatan')
            ->first();

        $sales = DB::table('penjualan')
            ->selectRaw("DATE(created_at) as date, DAYNAME(created_at) as day, SUM(bayar) as total_sales")
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date', 'day')
            ->orderBy('date')
            ->get()
            ->pluck('total_sales', 'day')
            ->toArray();

        Carbon::setLocale('id');
        $allDays = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('l');
            $allDays[$day] = 0;
        }

        $salesByDay = array_merge($allDays, $sales);

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('kategori', 'produk', 'member', 'salesByDay', 'pendapatan'), [
                'title' => 'Dashboard'
            ]);
        } else {
            return view('kasir.dashboard', [
                'title' => 'Dashboard'
            ]);
        }
    }

    public function data()
    {
        // $produk = Produk::with('stok')
        //     ->whereHas('stok', function ($query) {
        //         $query->whereColumn('stok', '<', 'produk.minimal_stok');
        //     })
        //     ->get();

        // $produk = Produk::with('stok')
        //     ->where(function ($query) {
        //         $query->whereHas('stok', function ($query) {
        //             $query->where('stok', '<', DB::raw('produk.minimal_stok')); // Compare stok from stok table to minimal_stok from barang table
        //         })
        //             ->orWhereDoesntHave('stok'); // Include barang with no stok
        //     })
        //     ->get();

        $produk = Produk::with('stok')
            ->leftJoinSub(
                DB::table('stok')
                    ->selectRaw('id_produk, SUM(stok) as total_stok')
                    ->whereNull('deleted_at')
                    ->groupBy('id_produk'),
                'stok_agregat',
                'produk.id_produk',
                '=',
                'stok_agregat.id_produk'
            )
            ->where(function ($query) {
                $query->whereRaw('IFNULL(stok_agregat.total_stok, 0) < produk.minimal_stok')
                    ->orWhereNull('stok_agregat.total_stok'); // Untuk produk yang tidak memiliki stok
            })
            ->whereNull('produk.deleted_at')
            ->get();


        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->editColumn('stok', function ($produk) {
                $totalStok = $produk->stok->where('tgl_kadaluarsa', '>=', now())->sum('stok');

                if ($totalStok == 0) {
                    return '<span class="badge bg-danger">Stok Habis</span>';
                } else {
                    return '<span class="badge bg-warning">Sisa ' . $totalStok . '</span>';
                }
            })
            ->rawColumns(['stok'])
            ->make(true);
    }
}
