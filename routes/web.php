<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsUnLocked;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', EnsureUserIsUnLocked::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users', UserController::class);
    Route::post('user-lock-status-change', [UserController::class, 'changeLockStatus'])->name('users.lock-status.change');
    Route::put('user-role-change', [UserController::class, 'changeRole'])->name('users.role.change');

});

require __DIR__ . '/auth.php';
