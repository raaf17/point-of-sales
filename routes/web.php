<?php

use App\Http\Controllers\{
    DashboardController,
    KategoriController,
    DiskonController,
    LaporanStokController,
    LogActivityController,
    ProdukController,
    MemberController,
    PenjualanController,
    PenjualanDetailController,
    SettingController,
    UserController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

    Route::group(['middleware' => 'level:1'], function () {
        Route::prefix('kategori')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori');
            Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
            Route::get('create', [KategoriController::class, 'create'])->name('kategori.create');
            Route::post('store', [KategoriController::class, 'store'])->name('kategori.store');
            Route::get('edit/{id?}', [KategoriController::class, 'edit'])->name('kategori.edit');
            Route::get('view/{id?}', [KategoriController::class, 'view'])->name('kategori.view');
            Route::post('update/{id?}', [KategoriController::class, 'update'])->name('kategori.update');
            Route::get('delete/{id?}', [KategoriController::class, 'delete'])->name('kategori.delete');
            Route::get('export', [KategoriController::class, 'export'])->name('kategori.export');
        });

        Route::prefix('produk')->group(function () {
            Route::get('/', [ProdukController::class, 'index'])->name('produk');
            Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
            Route::get('create', [ProdukController::class, 'create'])->name('produk.create');
            Route::get('addqty/{id?}', [ProdukController::class, 'addQty'])->name('produk.addqty');
            Route::post('storeqty/{id?}', [ProdukController::class, 'storeQty'])->name('produk.storeqty');
            Route::post('store', [ProdukController::class, 'store'])->name('produk.store');
            Route::get('edit/{id?}', [ProdukController::class, 'edit'])->name('produk.edit');
            Route::get('view/{id?}', [ProdukController::class, 'view'])->name('produk.view');
            Route::post('update/{id?}', [ProdukController::class, 'update'])->name('produk.update');
            Route::get('delete/{id?}', [ProdukController::class, 'delete'])->name('produk.delete');
            Route::get('export', [ProdukController::class, 'export'])->name('produk.export');
            Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
        });

        Route::prefix('diskon')->group(function () {
            Route::get('/', [DiskonController::class, 'index'])->name('diskon');
            Route::get('/diskon/data', [DiskonController::class, 'data'])->name('diskon.data');
            Route::get('create', [DiskonController::class, 'create'])->name('diskon.create');
            Route::post('store', [DiskonController::class, 'store'])->name('diskon.store');
            Route::get('edit/{id?}', [DiskonController::class, 'edit'])->name('diskon.edit');
            Route::get('view/{id?}', [DiskonController::class, 'view'])->name('diskon.view');
            Route::post('update/{id?}', [DiskonController::class, 'update'])->name('diskon.update');
            Route::get('delete/{id?}', [DiskonController::class, 'delete'])->name('diskon.delete');
            Route::get('export', [DiskonController::class, 'export'])->name('diskon.export');
        });
    });

    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
        Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
        Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
        Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
        Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

        Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
        Route::get('/transaksi/loadform/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
        Route::resource('/transaksi', PenjualanDetailController::class)
            ->except('create', 'show', 'edit');

        Route::prefix('member')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('member');
            Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
            Route::get('create', [MemberController::class, 'create'])->name('member.create');
            Route::post('store', [MemberController::class, 'store'])->name('member.store');
            Route::get('edit/{id?}', [MemberController::class, 'edit'])->name('member.edit');
            Route::get('view/{id?}', [MemberController::class, 'view'])->name('member.view');
            Route::post('update/{id?}', [MemberController::class, 'update'])->name('member.update');
            Route::get('delete/{id?}', [MemberController::class, 'delete'])->name('member.delete');
            Route::get('export', [MemberController::class, 'export'])->name('member.export');
        });

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
        Route::get('export', [PenjualanController::class, 'export'])->name('penjualan.export');
        Route::get('exportpdfpenjualan', [PenjualanController::class, 'exportPDF'])->name('penjualan.exportpdf');
        Route::get('filter', [PenjualanController::class, 'filter'])->name('penjualan.filter');
    });

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/laporan_stok/data', [LaporanStokController::class, 'data'])->name('laporan_stok.data');
        Route::resource('/laporan_stok', LaporanStokController::class);
        Route::get('exportstok', [LaporanStokController::class, 'export'])->name('laporan_stok.export');
        Route::get('exportpdf', [LaporanStokController::class, 'exportPDF'])->name('laporan_stok.exportpdf');
        Route::get('view/{id?}', [LaporanStokController::class, 'view'])->name('laporan_stok.view');

        Route::get('/logs_activity/data', [LogActivityController::class, 'data'])->name('logs_activity.data');
        Route::resource('/logs_activity', LogActivityController::class);

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('store', [UserController::class, 'store'])->name('user.store');
            Route::get('edit/{id?}', [UserController::class, 'edit'])->name('user.edit');
            Route::get('view/{id?}', [UserController::class, 'view'])->name('user.view');
            Route::post('update/{id?}', [UserController::class, 'update'])->name('user.update');
            Route::get('delete/{id?}', [UserController::class, 'delete'])->name('user.delete');
            Route::get('export', [UserController::class, 'export'])->name('user.export');
        });

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    });

    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    });
});
