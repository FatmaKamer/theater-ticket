<?php

use App\Http\Controllers\Admin\PlayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;

Route::get('/', function () {
    return view('welcome');
});


// Dashboard (giriş yapmış kullanıcılar için)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/play/{play}', [HomeController::class, 'show'])->name('play.show');
});

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function (){
    Route::get('/',function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('venues', VenueController::class);

    Route::resource('plays', PlayController::class);

});
