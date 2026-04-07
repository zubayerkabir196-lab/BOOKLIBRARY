<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('authors', AuthorController::class);
Route::view('/book-create','book-create')->name('book-create');
Route::view('/book-list','book-list')->name('book-list');
Route::view('/category-create','category-create')->name('category-create');
Route::view('/category-list','category-list')->name('category-list');
Route::view('/change-password','change-password')->name('change-password');
Route::view('/dashboard','dashboard')->name('dashboard');
Route::view('/edit-profile','edit-profile')->name('edit-profile');
Route::view('/login','login')->name('login');
Route::view('/signup','signup')->name('signup');