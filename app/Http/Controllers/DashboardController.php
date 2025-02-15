<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Produk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
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
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'salesByDay', 'pendapatan'), [
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
        $produk = Produk::whereColumn('stok', '<', 'minimal_stok')->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->editColumn('stok', function ($produk) {
                $html = "";
                if ($produk->stok == 0) {
                    $html = '<span class="badge bg-danger">Stok Habis</span>';
                } else {
                    $html = '<span class="badge bg-warning">Sisa ' . $produk->stok . '</span>';
                }

                return $html;
            })
            ->rawColumns(['stok'])
            ->make(true);
    }
}
