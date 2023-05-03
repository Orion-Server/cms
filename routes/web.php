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
        Route::get('/', fn() => view('pages.articles.index'))->name('index');
    });

Route::prefix('community')
    ->name('community.')
    ->group(function() {
        Route::get('photos', fn() => view('pages.community.photos.index'))->name('photos.index');
        Route::get('staff', fn() => view('pages.community.staff.index'))->name('staff.index');
        Route::get('rankings', fn() => view('pages.community.rankings.index'))->name('rankings.index');
    });
