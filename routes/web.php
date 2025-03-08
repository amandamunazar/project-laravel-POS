<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PemasokController;
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
// Route::get('kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

//route produk
Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

//route pemasok
Route::get('pemasok', [PemasokController::class, 'index'])->name('pemasok.index');
Route::post('pemasok/store', [PemasokController::class, 'store'])->name('pemasok.store');

//route transaksi
Route::get('transaksi', [OrderController::class, 'index'])->name('transaksi.create');
Route::post('transaksi/store', [OrderController::class, 'store'])->name('transaksi.store');
Route::get('/search-barang', [ProdukController::class, 'searchBarang']);
