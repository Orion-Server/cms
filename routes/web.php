<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\{
    AboutController,
    WebController,
    JailController,
    ClientController,
    ArticleController,
    External\RconController,
    Article\ArticleCommentController,
    CameraController,
    HelpQuestionController,
    RankingController,
    StaffController,
    UserSettingController,
    Auth\AuthSessionController,
    UserProfileController,
    Profile\RatingController as UserHomeRatingController,
    Profile\MessageController as UserHomeMessageController,
    Profile\ItemController as UserHomeItemController,
    ShopController,
    TeamController
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

Route::get('/set-language/{language}', [WebController::class, 'setLanguage'])->name('set-language');

Route::get('/', [WebController::class, 'index'])->name('index');
Route::get('/login', [WebController::class, 'index'])->name('login');
Route::get('/register', [WebController::class, 'index'])->name('register');

Route::post('/logout', [AuthSessionController::class, 'destroy'])->name('logout');

Route::get('jail', [JailController::class, 'show'])->name('jail');
Route::get('maintenance', [WebController::class, 'maintenance'])->name('maintenance');

Route::prefix('hotel')
    ->name('hotel.')
    ->middleware('auth')
    ->group(function () {
        Route::get('nitro', [ClientController::class, 'nitro'])->name('nitro');
        Route::get('flash', [ClientController::class, 'flash'])->name('flash');
        Route::post('client-errors', [ClientController::class, 'clientErrors'])
            ->name('client-errors')
            ->withoutMiddleware(VerifyCsrfToken::class);

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

        Route::post('{id}/{slug}/react', [ArticleController::class, 'toggleReaction'])
            ->middleware('auth')
            ->name('reactions.toggle');
    });

Route::prefix('community')
    ->name('community.')
    ->group(function () {
        Route::prefix('photos')
            ->name('photos.')
            ->group(function () {
                Route::get('/', [CameraController::class, 'index'])->name('index');
                Route::post('photo/{camera:id}/like', [CameraController::class, 'toggleLike'])
                    ->middleware('auth')
                    ->name('like');
            });

        Route::get('staff', [StaffController::class, 'index'])->name('staffs.index');
        Route::get('rankings', RankingController::class)
            ->name('rankings.index');

        Route::get('teams', [TeamController::class, 'index'])->name('teams.index');
    });

Route::name('users.')
    ->middleware('auth')
    ->group(function () {

        Route::prefix('profile')
            ->name('profile.')
            ->middleware('throttle:120,1')
            ->group(function () {
                Route::get('{username}', [UserProfileController::class, 'show'])->name('show')->withoutMiddleware('auth');
                Route::get('{username}/placed-items', [UserProfileController::class, 'getPlacedItems'])->withoutMiddleware('auth');
                Route::get('{username}/widget-content/{itemId}', [UserHomeItemController::class, 'getWidgetContent'])->name('widget-content');

                Route::post('{username}/save', [UserProfileController::class, 'save'])->name('save');
                Route::post('{username}/buy-item', [UserHomeItemController::class, 'store'])->name('items.store');
                Route::post('{username}/rating', [UserHomeRatingController::class, 'store'])->name('ratings.store');
                Route::post('{username}/message', [UserHomeMessageController::class, 'store'])->name('comments.store');
        });

        Route::prefix('user')
            ->group(function() {
                Route::prefix('settings')
                    ->name('settings.')
                    ->group(function () {
                        Route::match(['GET', 'POST'], '/{page?}', [UserSettingController::class, 'index'])->name('index');
                    });
            });
    });

Route::prefix('support')
    ->name('support.')
    ->middleware('auth', 'throttle:60,1')
    ->group(function() {
        Route::prefix('questions')
            ->name('questions.')
            ->group(function() {
                Route::get('/', [HelpQuestionController::class, 'index'])->name('index');
                Route::get('category/{slug}', [HelpQuestionController::class, 'category'])->name('categories.show');
                Route::get('{id}/{slug}', [HelpQuestionController::class, 'show'])->name('show');
            });
    });

Route::prefix('about')
    ->name('about.')
    ->group(function() {
        Route::get('discord', [AboutController::class, 'discordInvite'])->name('discord');
        Route::get('safety', [AboutController::class, 'safety'])->name('safety');
    });

Route::prefix('shop')
    ->name('shop.')
    ->middleware('auth')
    ->group(function() {
        Route::get('/', [ShopController::class, 'index'])->name('index');
    });
