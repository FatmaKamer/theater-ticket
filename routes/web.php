<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (giriş yapmış kullanıcılar için)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    Route::get('/home', function () {
        return view('home');
    })->name('home');

});

// Test route'u (admin middleware testi)
Route::middleware(['auth', 'admin'])->get('/admin-test', function () {
    return 'Admin middleware çalışıyor!';
});
