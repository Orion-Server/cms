<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InviteController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ShopProductController;

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
        Route::prefix('shop')
            ->name('shop.')
            ->group(function() {
                Route::get('categories', [ProfileController::class, 'getShopCategories'])->name('categories');
                Route::get('category/{categoryId}/items', [ProfileController::class, 'getShopItemsByCategory'])->name('items-by-category');
                Route::get('type/{type}/items', [ProfileController::class, 'getShopItemsByType'])->name('items-by-type');
            });

        Route::get('{username}/inventory', [ProfileController::class, 'getUserInventory'])->name('inventory');
    });

Route::prefix('shop')
    ->name('shop.')
    ->group(function() {
        Route::get('products/{id}', [ShopProductController::class, 'show'])->name('products.show');
    });
