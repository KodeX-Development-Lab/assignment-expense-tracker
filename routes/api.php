<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralSettingsController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/auth/')->name('api.auth.')->group(function () {
    // Auth routes
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(JwtMiddleware::class);
    Route::get('/me', [AuthController::class, 'getUser'])->name('me')->middleware(JwtMiddleware::class);
    Route::post('/password/change', [AuthController::class, 'changePassword'])->name('password.change')->middleware(JwtMiddleware::class);

    // Forgot Pasword
    // Route::post('password/forgot', [AuthController::class, 'forgotPassword']);

    // Reset Password
    // Route::get('password/reset/{token}', [AuthController::class, 'checkResetPasswordToken']);
    // Route::post('password/reset', [AuthController::class, 'resetPassword']);
});

// Route to redirect to Google's OAuth page
Route::get('v1/auth/google/redirect', [GoogleAuthController::class, 'redirectToAuth'])->name('auth.google.redirect');
Route::get('v1/auth/google/callback', [GoogleAuthController::class, 'handleAuthCallback'])->name('auth.google.callback');

Route::middleware(JwtMiddleware::class)->prefix('v1/profile/')->name('profile.')->group(function () {
    Route::get('me', [ProfileController::class, 'show'])->name('show');
    Route::put('me', [ProfileController::class, 'update'])->name('update');
    Route::post('me/upload-profile', [ProfileController::class, 'uploadProfile'])->name('upload-profile');
});

Route::middleware(JwtMiddleware::class)->prefix('v1/general/settings/')->name('general-settings.')->group(function () {
    Route::get('', [GeneralSettingsController::class, 'show'])->name('show');
    Route::put('', [GeneralSettingsController::class, 'update'])->name('update');
    Route::post('upload-logo', [GeneralSettingsController::class, 'uploadLogo'])->name('upload-logo');
});
