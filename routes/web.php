<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|sss
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Lojin
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authentication']);
Route::post('/logout', [LoginController::class, 'logout']);

// Daftar
Route::get('/daftar', [DaftarController::class, 'index'])->middleware('guest');
Route::post('/daftar', [DaftarController::class, 'store']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// Route Menu Produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk')->middleware('auth');
Route::get('/produk/tambah', [ProdukController::class, 'create'])->middleware('auth');
Route::post('/produk', [ProdukController::class, 'store']);
Route::post('/produk/{produk}/edit', [ProdukController::class, 'edit']);
Route::post('/produk/{produk}/update', [ProdukController::class, 'update']);
Route::post('/produk/{produk}/hapus',[ProdukController::class, 'destroy']);
Route::post('/importproduk',[ProdukController::class, 'import']);

// Route Menu Transaksi
Route::get('/transaksi', [PembelianController::class, 'index'])->name('transaksi')->middleware('auth');
Route::get('/transaksi/tambah', [PembelianController::class, 'create'])->middleware('auth');
Route::post('/transaksi', [PembelianController::class, 'store']);
Route::post('/transaksi/{transaksi}/edit', [PembelianController::class, 'edit']);
Route::post('/transaksi/{transaksi}', [PembelianController::class, 'update']);
Route::post('/transaksi/detail/{id}', [PembelianController::class, 'detail']);
Route::post('/importtransaksi',[PembelianController::class, 'import']);

Route::post('/transaksi/{transaksi}/hapus',[TransaksiController::class, 'destroy']);
Route::post('/importdetailtransaksi',[TransaksiController::class, 'import']);

Route::get('/analisis', [PembelianController::class, 'index'])->middleware('auth');

// Route Menu Staf
Route::get('/staf', [UserController::class, 'index'])->middleware('auth');
Route::get('/staf/tambah', [UserController::class, 'create'])->middleware('auth');
Route::post('/staf', [UserController::class, 'store']);
Route::post('/staf/{staf}/edit', [UserController::class, 'edit']);
Route::post('/staf/{staf}', [UserController::class, 'update']);
Route::post('/staf/{staf}/hapus',[UserController::class, 'destroy']);

// Route Menu Analisis
Route::get('/analisis', [AnalisisController::class, 'index'])->middleware('kepalatoko');
Route::post('/analisisproduk', [AnalisisController::class, 'fpgrowth'])->middleware('kepalatoko');
//Route::post('/analisis/result', [AnalisisController::class, 'fpgrowth']);

