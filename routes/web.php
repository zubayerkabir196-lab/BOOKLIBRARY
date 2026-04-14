<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\categoriesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/change-password', 'change-password')->name('change-password');
    Route::view('/edit-profile', 'edit-profile')->name('edit-profile');
    Route::resource('authors', AuthorController::class);
    Route::resource('categories', categoriesController::class);
    Route::resource('Books', BooksController::class);
});



    // ✅ Only accessible when NOT logged in
    Route::view('/login', 'login')->name('login');
    Route::view('/signup', 'signup')->name('signup');
    Route::post('/registerSave', [RegisterController::class, 'store'])->name('registerSave');
    Route::post('/loginAuth', [RegisterController::class, 'loginAuth'])->name('loginAuth');