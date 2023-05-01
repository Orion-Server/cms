<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn() => view('index'))->name('index');

Route::prefix('articles')
    ->name('articles.')
    ->group(function() {
        Route::get('/', fn() => view('articles.index'))->name('index');
    });

Route::prefix('community')
    ->name('community.')
    ->group(function() {
        Route::get('photos', fn() => view('community.photos.index'))->name('photos.index');
        Route::get('staff', fn() => view('community.staff.index'))->name('staff.index');
    });
