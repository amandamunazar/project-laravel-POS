<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'auth.login')->name('login');;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('home', function () {
    return view('home');
})->name('home');
Route::post('login', [LoginController::class, 'login'])->name('login-cek');

//route kategori
Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('kategori/create', [KategoriController::class, 'store'])->name('kategori.store');
Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');

//route produk
Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');


//route pemasok
Route::get('pemasok', [PemasokController::class, 'index'])->name('pemasok.index');
Route::post('pemasok/store', [PemasokController::class, 'store'])->name('pemasok.store');
Route::delete('/pemasok/{id}', [PemasokController::class, 'destroy'])->name('pemasok.destroy');
Route::put('/pemasok/{id}', [PemasokController::class, 'update'])->name('pemasok.update');

//route transaksi
Route::get('transaksi/create', [OrderController::class, 'index'])->name('transaksi.create');
Route::get('laporan/transaksi', [OrderController::class, 'index1'])->name('laporan.transaksi');
Route::post('transaksi/store', [OrderController::class, 'store'])->name('transaksi.store');
Route::get('/search-barang', [ProdukController::class, 'searchBarang']);
Route::get('/transaksi', [OrderController::class, 'index'])->name('transaksi.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

Route::get('/laporan/transaksi/pdf', [OrderController::class, 'exportPdf'])->name('laporan.transaksi.pdf');



//route pembelian

Route::get('/pembelian', [PembelianController::class, 'pembelian'])->name('pembelian');
Route::get('/pembelian/create', [PembelianController::class, 'createPembelian'])->name('pembelian.create');
Route::get('/pembelian/search-barang', [PembelianController::class, 'searchPembelian'])->name('pembelian.search');
Route::get('/pembelian/search-pemasok', [PembelianController::class, 'searchPemasok'])->name('pembelian.search-pemasok');
Route::post('/pembelian/store', [PembelianController::class, 'storePembelian'])->name('pembelian.store');

Route::get('/pembelian/{pembelian}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
Route::put('/pembelian/{pembelian}', [PembelianController::class, 'update'])->name('pembelian.update');
Route::delete('/pembelian/{pembelian}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

Route::get('/pembelian/export-pdf', [PembelianController::class, 'exportPdf'])->name('pembelian.exportPdf');
Route::get('/laporan', [PembelianController::class, 'index'])->name('laporan.index');



//route Member
Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

//Route Pengajuan_barang
Route::get('/pengajuan', [PengajuanBarangController::class, 'index'])->name('pengajuan.index');
Route::post('/pengajuan', [PengajuanBarangController::class, 'store'])->name('pengajuan.store');
Route::put('/pengajuan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuan.update');
Route::put('/pengajuan/{id}/status', [PengajuanBarangController::class, 'updateStatus'])->name('pengajuan.updateStatus');
Route::delete('/pengajuan/{id}', [PengajuanBarangController::class, 'destroy'])->name('pengajuan.destroy');

Route::get('/pengajuan/export-excel', [PengajuanBarangController::class, 'exportExcel'])->name('pengajuan.exportExcel');
Route::get('/pengajuan/export-pdf', [PengajuanBarangController::class, 'exportPDF'])->name('pengajuan.exportPDF');

// route Chart 
Route::get('/chart-data', [OrderController::class, 'getChartData'])->name('chart.data');