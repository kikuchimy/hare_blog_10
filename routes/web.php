<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\OAuthController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PostController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('posts', PostController::class);
Route::resource('posts', PostController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('posts', PostController::class)
    ->only(['show', 'index']);

Route::resource('posts.comments', CommentController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

require __DIR__.'/auth.php';

// // authから始まるルーティングに認証前にアクセスがあった場合
// Route::prefix('auth')->middleware('guest')->group(function () {
//     // auth/githubにアクセスがあった場合はOAuthControllerのredirectToProviderアクションへルーティング
//     Route::get('/github', [OAuthController::class, 'redirectToProvider'])
//         ->where('provider', 'github')
//         ->name('redirectToProvider');

//     // auth/github/callbackにアクセスがあった場合はOAuthControllerのoauthCallbackアクションへルーティング
//     Route::get('/github/callback', [OAuthController::class, 'oauthCallback'])
//         ->where('provider', 'github')
//         ->name('oauthCallback');
// });

// authから始まるルーティングに認証前にアクセスがあった場合
Route::prefix('auth')->middleware('guest')->group(function () {
    // auth/githubにアクセスがあった場合はOAuthControllerのredirectToProviderアクションへルーティング
    Route::get('/{provider}', [OAuthController::class, 'redirectToProvider'])
        ->where('provider', 'github|google')
        ->name('redirectToProvider');

    // auth/github/callbackにアクセスがあった場合はOAuthControllerのoauthCallbackアクションへルーティング
    Route::get('/{provider}/callback', [OAuthController::class, 'oauthCallback'])
        ->where('provider', 'github|google')
        ->name('oauthCallback');
});
