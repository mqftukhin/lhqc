<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasterPartController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Api\QcRecordController;
// ⬇️ TAMBAHKAN LINE INI ⬇️
use App\Http\Controllers\Api\MasterOpController;

// Route untuk mencari data Master Part berdasarkan scan kode
Route::get('/master-parts/{kode_part}', [MasterPartController::class, 'show']);

// Route untuk scan/verifikasi ID Operator
Route::get('/master-ops/{id_op}', [MasterOpController::class, 'show']);

// Route untuk submit hasil inspeksi QC dari operator
Route::post('/qc-records', [QcRecordController::class, 'store']);

// Route untuk bulk upload data CSV dari halaman Admin
Route::post('/master-parts/import', [ImportController::class, 'importMasterPart']);
Route::post('/master-ops/import', [ImportController::class, 'importMasterOp']);
