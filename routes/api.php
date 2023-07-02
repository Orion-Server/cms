<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InviteController;
use App\Http\Controllers\Api\UserProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('referral/{code}', [InviteController::class, 'getReferralUsername']);
Route::post('bbcode/preview', [ApiController::class, 'getBBCodePreview'])->name('bbcode.preview');

Route::prefix('hotel')
    ->name('hotel.')
    ->group(function() {
        Route::get('online-count', [ApiController::class, 'getOnlineCount'])->name('online-count');
    });

Route::prefix('profile')
    ->name('profile.')
    ->group(function() {
        Route::get('{username}/inventory', [UserProfileController::class, 'getInventory'])->name('inventory');
    });
