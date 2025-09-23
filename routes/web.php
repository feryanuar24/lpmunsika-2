<?php

use App\Http\Controllers\Article\CategoryController;
use App\Http\Controllers\Article\TagController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Article\ArticleThumbnailController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionRole\PermissionController;
use App\Http\Controllers\PermissionRole\PermissionRoleController;
use App\Http\Controllers\PermissionRole\RoleController;
use App\Http\Controllers\User\UserController;

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

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

Route::get('articles/thumbnail/{path}', [ArticleThumbnailController::class, 'show'])
    ->where('path', '.*')
    ->name('articles.thumbnail');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [VerificationController::class, 'create'])
        ->name('verification.notice');

    Route::post('/email/verification-notification', [VerificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'update'])
        ->middleware(['signed'])
        ->name('verification.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::resource('/users', UserController::class)->middleware('permission:users_management');

    Route::resource('/categories', CategoryController::class)->middleware('permission:categories_management');
    Route::resource('/tags', TagController::class)->middleware('permission:tags_management');
    Route::resource('/articles', ArticleController::class)->middleware('permission:articles_management');
    Route::resource('/articles/{article}/comments', CommentController::class)->middleware('permission:articles_management');

    Route::resource('/permissions', PermissionController::class)->middleware('permission:permission_role_management');
    Route::resource('/roles', RoleController::class)->middleware('permission:permission_role_management');
    Route::resource('/permission-role', PermissionRoleController::class)->middleware('permission:permission_role_management')->except('destroy');
    Route::delete('/permission-role', [PermissionRoleController::class, 'destroy'])->middleware('permission:permission_role_management')->name('permission-role.destroy');
});
