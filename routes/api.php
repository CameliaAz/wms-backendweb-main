<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LokasiBarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;

/*
|---------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
| This file is for registering API routes for your application.
| These routes are loaded by the RouteServiceProvider and will be assigned 
| to the "api" middleware group. Make something great!
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', [AuthController::class, 'me']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

// Grouping API routes with versioning and applying auth middleware for JWT
Route::middleware('auth:api')->prefix('v1')->group(function () {

    // Users Routes
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);

    // Produk Routes
    Route::get('produk', [ProdukController::class, 'index']);
    Route::post('produk', [ProdukController::class, 'store']);
    Route::get('produk/{id}', [ProdukController::class, 'show']);
    Route::put('produk/{id}', [ProdukController::class, 'update']);
    Route::delete('produk/{id}', [ProdukController::class, 'destroy']);

    // Kategori Routes
    Route::get('kategori', [KategoriController::class, 'index']);
    Route::post('kategori', [KategoriController::class, 'store']);
    Route::get('kategori/{id}', [KategoriController::class, 'show']);
    Route::put('kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);

    // Lokasi Barang Routes
    Route::get('lokasi-barang', [LokasiBarangController::class, 'index']);
    Route::post('lokasi-barang', [LokasiBarangController::class, 'store']);
    Route::get('lokasi-barang/{id}', [LokasiBarangController::class, 'show']);
    Route::put('lokasi-barang/{id}', [LokasiBarangController::class, 'update']);
    Route::delete('lokasi-barang/{id}', [LokasiBarangController::class, 'destroy']);

    // Supplier Routes
    Route::get('supplier', [SupplierController::class, 'index']);
    Route::post('supplier', [SupplierController::class, 'store']);
    Route::get('supplier/{id}', [SupplierController::class, 'show']);
    Route::put('supplier/{id}', [SupplierController::class, 'update']);
    Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);

    // Pembelian Routes
    Route::get('pembelian', [PembelianController::class, 'index']);
    Route::post('pembelian', [PembelianController::class, 'store']);
    Route::get('pembelian/{id}', [PembelianController::class, 'show']);
    Route::put('pembelian/{id}', [PembelianController::class, 'update']);
    Route::delete('pembelian/{id}', [PembelianController::class, 'destroy']);

    // Pembelian Detail Routes
    Route::get('pembelian-detail', [PembelianDetailController::class, 'index']);
    Route::post('pembelian-detail', [PembelianDetailController::class, 'store']);
    Route::get('pembelian-detail/{id}', [PembelianDetailController::class, 'show']);
    Route::put('pembelian-detail/{id}', [PembelianDetailController::class, 'update']);
    Route::delete('pembelian-detail/{id}', [PembelianDetailController::class, 'destroy']);

    // Penjualan Routes
    Route::get('penjualan', [PenjualanController::class, 'index']);
    Route::post('penjualan', [PenjualanController::class, 'store']);
    Route::get('penjualan/{id}', [PenjualanController::class, 'show']);
    Route::put('penjualan/{id}', [PenjualanController::class, 'update']);
    Route::delete('penjualan/{id}', [PenjualanController::class, 'destroy']);

    // Penjualan Detail Routes
    Route::get('penjualan-detail', [PenjualanDetailController::class, 'index']);
    Route::post('penjualan-detail', [PenjualanDetailController::class, 'store']);
    Route::get('penjualan-detail/{id}', [PenjualanDetailController::class, 'show']);
    Route::put('penjualan-detail/{id}', [PenjualanDetailController::class, 'update']);
    Route::delete('penjualan-detail/{id}', [PenjualanDetailController::class, 'destroy']);
    
});
