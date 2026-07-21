<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;

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

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function (){
    Route::get('/',function () {
        return view('admin.dashboaard');
    })->name('dashboard');

    Route::resource('users', UserController::class);
});