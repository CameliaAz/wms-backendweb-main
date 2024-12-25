<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\BarangController;

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
// Users Routes
Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);
// Supplier Routes
Route::get('supplier', [SupplierController::class, 'index']);
Route::post('supplier', [SupplierController::class, 'store']);
Route::get('supplier/{id}', [SupplierController::class, 'show']);
Route::put('supplier/{id}', [SupplierController::class, 'update']);
Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);
// Supplier Routes
Route::get('kategori', [KategoriController::class, 'index']);
Route::post('kategori', [KategoriController::class, 'store']);
Route::get('kategori/{id}', [KategoriController::class, 'show']);
Route::put('kategori/{id}', [KategoriController::class, 'update']);
Route::delete('kategori/{id}', [KategoriController::class, 'destroy']);
// Rak Routes
Route::get('rak', [RakController::class, 'index']);
Route::post('rak', [RakController::class, 'store']);
Route::get('rak/{id}', [RakController::class, 'show']);
Route::put('rak/{id}', [RakController::class, 'update']);
Route::delete('rak/{id}', [RakController::class, 'destroy']);
// Barang Routes
Route::get('barang', [BarangController::class, 'index']);
Route::post('barang', [BarangController::class, 'store']);
Route::get('barang/{id}', [BarangController::class, 'show']);
Route::put('barang/{id}', [BarangController::class, 'update']);
Route::delete('barang/{id}', [BarangController::class, 'destroy']);
