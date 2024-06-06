<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BengkelController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DetailTransaksiController;

Route::post('/detail_transaksi/store', [DetailTransaksiController::class, 'store'])->middleware('auth:sanctum');
Route::get('/detail_transaksi', [DetailTransaksiController::class, 'index'])->middleware('auth:sanctum');
Route::put('/detail_transaksi/{id}', [DetailTransaksiController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/detail_transaksi/{id}', [DetailTransaksiController::class, 'delete'])->middleware('auth:sanctum');
Route::put('/detail_transaksis/{id}', [DetailTransaksiController::class, 'updateKeuntungan'])->middleware('auth:sanctum');
Route::get('/keuntungan_bersih/{id}', [DetailTransaksiController::class, 'getKeuntunganBersih'])->middleware('auth:sanctum');

Route::post('/barang_masuk/store', [BarangMasukController::class, 'store'])->middleware('auth:sanctum');
Route::put('/barang_masuk/{barang_id}/reduce-stock', [BarangMasukController::class, 'reduceStock'])->middleware('auth:sanctum');
Route::get('/barang_masuk/{barang_id}', [BarangMasukController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/barang_masuk/{id}', [BarangMasukController::class, 'delete'])->middleware('auth:sanctum');
Route::put('/barang_masuk/{id}', [BarangMasukController::class, 'update'])->middleware('auth:sanctum');

Route::put('/barang/{id}', [BarangController::class, 'update'])->middleware('auth:sanctum');
Route::get('/barang/{id}', [BarangController::class, 'show'])->middleware('auth:sanctum');
Route::post('/barang/store', [BarangController::class, 'store'])->middleware('auth:sanctum');
Route::get('/barang', [BarangController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/barang/{id}', [BarangController::class, 'delete'])->middleware('auth:sanctum');

Route::put('/transaction/{id}', [TransactionController::class, 'update'])->middleware('auth:sanctum');
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->middleware('auth:sanctum');
Route::post('/transaction/store', [TransactionController::class, 'store'])->middleware('auth:sanctum');
Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/transaction/{id}', [TransactionController::class, 'delete'])->middleware('auth:sanctum');
Route::get('/transactions', [TransactionController::class, 'dataTransaksiMekanik'])->middleware('auth:sanctum');

Route::put('/mechanic/{id}', [MechanicController::class, 'update'])->middleware('auth:sanctum');
Route::put('/mechanicPendapatan/{id}', [MechanicController::class, 'updatePendapatan'])->middleware('auth:sanctum');
Route::get('/mechanic/{id}', [MechanicController::class, 'show'])->middleware('auth:sanctum');
Route::post('/mechanic/store', [MechanicController::class, 'store'])->middleware('auth:sanctum');
Route::get('/mechanic', [MechanicController::class, 'index'])->middleware('auth:sanctum');
Route::delete('/mechanic/{id}', [MechanicController::class, 'delete'])->middleware('auth:sanctum');

Route::post('/bengkel/store', [BengkelController::class, 'store']);
Route::get('/bengkel/{id}', [BengkelController::class, 'show'])->middleware('auth:sanctum');
Route::put('/bengkel/{id}', [BengkelController::class, 'update'])->middleware('auth:sanctum');

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::get('/user/{id}', [AuthenticationController::class, 'show'])->middleware('auth:sanctum');
Route::post('/user/store', [AuthenticationController::class, 'store'])->middleware('auth:sanctum');

