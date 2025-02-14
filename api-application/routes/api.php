<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormatAController;
use App\Http\Controllers\FormatBAController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\StatistikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Endpoint privat Bearer protected
 * 
 */
Route::group(['middleware' => 'auth:sanctum'], function ($router) {

    /**
     * Endpoint untuk autentikasi
     * 
     */
    Route::post('/auth', [AuthController::class, 'authData']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/reset-password', [AuthController::class, 'resetPassword']);

    /**
     * Endpoint untuk edukasi
     * 
     */
    Route::post('/edukasi', [EdukasiController::class, 'post']);
    Route::put('/edukasi', [EdukasiController::class, 'put']);
    Route::delete('/edukasi', [EdukasiController::class, 'delete']);

    /**
     * Endpoint untuk berita
     * 
     */
    Route::post('/berita', [BeritaController::class, 'post']);
    Route::put('/berita', [BeritaController::class, 'put']);
    Route::delete('/berita', [BeritaController::class, 'delete']);

    /**
     * Endpoint untuk gambar
     * 
     */
    Route::post('/gambar', [GambarController::class, 'post']);
    Route::delete('/gambar', [GambarController::class, 'delete']);

    /**
     * Endpoint untuk posyandu
     * 
     */
    Route::put('/posyandu', [PosyanduController::class, 'put']);

    /**
     * Endpoint untuk admin
     * 
     */
    Route::get('/admin', [AdminController::class, 'get']);
    Route::post('/admin', [AdminController::class, 'post']);
    Route::put('/admin', [AdminController::class, 'put']);
    Route::delete('/admin', [AdminController::class, 'delete']);

    /**
     * Endpoint untuk format-a
     * 
     */
    Route::get('/format-a', [FormatAController::class, 'get']);
    Route::post('/format-a', [FormatAController::class, 'post']);
    Route::put('/format-a', [FormatAController::class, 'put']);
    Route::delete('/format-a', [FormatAController::class, 'delete']);
    Route::get('/listtahun', [FormatAController::class, 'getListTahun']);

    /**
     * Endpoint untuk format-a
     * 
     */
    Route::get('/format-ba', [FormatBAController::class, 'get']);
    Route::post('/format-ba', [FormatBAController::class, 'post']);
    Route::put('/format-ba', [FormatBAController::class, 'put']);
    Route::delete('/format-ba', [FormatBAController::class, 'delete']);

    /**
     * Endpoint untuk export file excel
     * 
     */
    Route::prefix('export')->group(function () {

        Route::get('/format-a', [ExportController::class, 'exportFormatAExcel']);

    });

    /**
     * Endpoint untuk mendapatkan data statistik
     * 
     */
    Route::prefix('statistik')->group(function () {

        Route::get('/dashboard', [StatistikController::class, 'dashboard']);

    });
});

/**
 * Endpoint public
 * 
 */
Route::post('/login', [AuthController::class, 'login']);

Route::get('/edukasi', [EdukasiController::class, 'get']);
Route::get('/berita', [BeritaController::class, 'get']);
Route::get('/gambar', [GambarController::class, 'get']);
Route::get('/posyandu', [PosyanduController::class, 'get']);
Route::get('/jabatan', [AdminController::class, 'jabatan']);
