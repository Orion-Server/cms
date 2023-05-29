<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    WebController,
    JailController,
    ClientController,
    ArticleController,
    External\RconController,
    Article\ArticleCommentController,
    RankingController,
    StaffController,
    UserSettingController
};

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

Route::get('/', [WebController::class, 'index'])->name('index');
Route::get('/login', [WebController::class, 'index'])->name('login');
Route::get('/register', [WebController::class, 'index'])->name('register');

Route::get('jail', [JailController::class, 'show'])->name('jail');

Route::prefix('hotel')
    ->name('hotel.')
    ->middleware('auth')
    ->group(function () {
        Route::get('nitro', [ClientController::class, 'nitro'])->name('nitro');

        Route::prefix('rcon')
            ->name('rcon.')
            ->group(function () {
                Route::post('follow-user/{user}', [RconController::class, 'followUser'])->name('follow-user')
                    ->middleware('throttle:15,1');
            });
    });

Route::prefix('articles')
    ->name('articles.')
    ->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('{id}/{slug}', [ArticleController::class, 'show'])->name('show');

        Route::post('{id}/{slug}/comment', [ArticleCommentController::class, 'store'])
            ->middleware('auth')
            ->name('comments.store');
    });

Route::prefix('community')
    ->name('community.')
    ->group(function () {
        Route::get('photos', fn () => view('pages.community.photos.index'))->name('photos.index');
        Route::get('staff', [StaffController::class, 'index'])->name('staffs.index');
        Route::get('rankings', RankingController::class)->name('rankings.index');
    });

Route::prefix('user')
    ->name('users.')
    ->group(function () {

        // User Settings
        Route::prefix('settings')
            ->name('settings.')
            ->group(function () {
                Route::match(['GET', 'POST'], '/{page?}', [UserSettingController::class, 'index'])->name('index');
            });
    });
