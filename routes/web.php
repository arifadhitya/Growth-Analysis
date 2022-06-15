<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AnalisisController;
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
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authentication']);

// Dashboard
Route::get('/dashboard', function(){
    return view('dashboard/index');
});

// Route Menu Produk
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/tambah', [ProdukController::class, 'create']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::post('/produk/{produk}/edit', [ProdukController::class, 'edit']);
Route::post('/produk/{produk}', [ProdukController::class, 'update']);
Route::post('/produk/{produk}/hapus',[ProdukController::class, 'destroy']);
Route::post('/importproduk',[ProdukController::class, 'import']);

// Route Menu Transaksi
Route::get('/transaksi', [PembelianController::class, 'index']);
Route::get('/transaksi/tambah', [PembelianController::class, 'create']);
Route::post('/transaksi', [PembelianController::class, 'store']);
Route::post('/transaksi/{transaksi}/edit', [PembelianController::class, 'edit']);
Route::post('/transaksi/{transaksi}', [PembelianController::class, 'update']);
Route::post('/transaksi/detail/{id}', [PembelianController::class, 'detail']);
Route::post('/importtransaksi',[PembelianController::class, 'import']);

Route::post('/importdetailtransaksi',[TransaksiController::class, 'import']);

Route::get('/analisis', [PembelianController::class, 'index']);

// Route Menu Staf
Route::get('/staf', [UserController::class, 'index']);
Route::get('/staf/tambah', [UserController::class, 'create']);
Route::post('/staf', [UserController::class, 'store']);
Route::post('/staf/{staf}/edit', [UserController::class, 'edit']);
Route::post('/staf/{staf}', [UserController::class, 'update']);
Route::post('/staf/{staf}/hapus',[UserController::class, 'destroy']);

// Route Menu Analisis
Route::get('/analisis', [AnalisisController::class, 'index']);
Route::post('/analisisproduk', [AnalisisController::class, 'fpgrowth']);
