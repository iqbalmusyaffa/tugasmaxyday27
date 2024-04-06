<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;

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

// Route::get('/', [WelcomeController::class, 'index']);
// Route::get('/{id}', [WelcomeController::class, 'index']);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/two-factor-auth/setup', [ProfileController::class, 'showTwoFactorAuthSetupForm'])->name('profile.two-factor-auth.setup');
    Route::post('/profile/two-factor-auth/enable', [ProfileController::class, 'enableTwoFactorAuth'])->name('profile.two-factor-auth.enable');
    Route::post('/profile/two-factor-auth/disable', [ProfileController::class, 'disableTwoFactorAuth'])->name('profile.two-factor-auth.disable');
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
// Tag
    Route::resource('tags', TagController::class);
// Komentar
    Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::middleware('guest')->group(function () {
    // ...
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'loginSocial'])
        ->name('socialite.auth');

    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
        ->name('socialite.callback');
});
