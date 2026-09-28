<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Saat membuka http://127.0.0.1:8000, langsung muncul halaman Input QC
Route::get('/', function () {
    return Inertia::render('Input'); // 'Input' sesuai dengan nama file Input.vue Anda
});

// Rute untuk halaman lainnya
Route::get('/admin', function () {
    return Inertia::render('Admin');
});

Route::get('/bpbfg', function () {
    return Inertia::render('BPBFG');
});
