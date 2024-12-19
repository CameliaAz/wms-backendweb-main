<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MasukController;
use App\Http\Controllers\PemindahanController;
use App\Http\Controllers\KeluarController;


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
   
    // Kategori Routes
    Route::get('kategori', [KategoriController::class, 'index']);
    Route::post('kategori', [KategoriController::class, 'store']);
    Route::get('kategori/{id}', [KategoriController::class, 'show']);
    Route::put('kategori/{id}', [KategoriController::class, 'update']);
    Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);

    // Barang Routes
    Route::get('barang', [BarangController::class, 'index']);
    Route::post('barang', [BarangController::class, 'store']);
    Route::get('barang/{id}', [BarangController::class, 'show']);
    Route::put('barang/{id}', [BarangController::class, 'update']);
    Route::delete('barang/{id}', [BarangController::class, 'destroy']);


    // Rak Routes
    Route::get('rak', [RakController::class, 'index']);
    Route::post('rak', [RakController::class, 'store']);
    Route::get('rak/{id}', [RakController::class, 'show']);
    Route::put('rak/{id}', [RakController::class, 'update']);
    Route::delete('rak/{id}', [RakController::class, 'destroy']);

    // Supplier Routes
    Route::get('supplier', [SupplierController::class, 'index']);
    Route::post('supplier', [SupplierController::class, 'store']);
    Route::get('supplier/{id}', [SupplierController::class, 'show']);
    Route::put('supplier/{id}', [SupplierController::class, 'update']);
    Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);

    // Masuk Routes
    Route::get('masuk', [MasukController::class, 'index']);
    Route::post('masuk', [MasukController::class, 'store']);
    Route::get('masuk/{id}', [MasukController::class, 'show']);
    Route::put('masuk/{id}', [MasukController::class, 'update']);
    Route::delete('masuk/{id}', [MasukController::class, 'destroy']);

    // Pemindahan Routes
    Route::get('pemindahan', [PemindahanController::class, 'index']);
    Route::post('pemindahan', [PemindahanController::class, 'store']);
    Route::get('pemindahan/{id}', [PemindahanController::class, 'show']);
    Route::put('pemindahan/{id}', [PemindahanController::class, 'update']);
    Route::delete('pemindahan/{id}', [PemindahanController::class, 'destroy']);

    // keluar Routes
    Route::get('keluar', [KeluarController::class, 'index']);
    Route::post('keluar', [KeluarController::class, 'store']);
    Route::get('keluar/{id}', [KeluarController::class, 'show']);
    Route::put('keluar/{id}', [KeluarController::class, 'update']);
    Route::delete('keluar/{id}', [KeluarController::class, 'destroy']);

        
});
