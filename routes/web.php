<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// AdminLTE scaffold routes
Route::middleware(['web', 'auth'])->prefix('admin')->name('adminlte.')->group(function () {
    // [adminlte:mailbox]
    Route::get('mailbox', [\App\Http\Controllers\AdminLte\MailboxController::class, 'index'])->name('mailbox.index');
    Route::get('mailbox/compose', [\App\Http\Controllers\AdminLte\MailboxController::class, 'create'])->name('mailbox.create');
    Route::post('mailbox', [\App\Http\Controllers\AdminLte\MailboxController::class, 'store'])->name('mailbox.store');
    Route::get('mailbox/{message}', [\App\Http\Controllers\AdminLte\MailboxController::class, 'show'])->name('mailbox.show');
    Route::delete('mailbox/{message}', [\App\Http\Controllers\AdminLte\MailboxController::class, 'destroy'])->name('mailbox.destroy');

    // [adminlte:profile]
    Route::get('profile', [\App\Http\Controllers\AdminLte\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\AdminLte\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\AdminLte\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('profile/avatar', [\App\Http\Controllers\AdminLte\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::put('profile/other-sessions', [\App\Http\Controllers\AdminLte\ProfileController::class, 'logoutOtherDevices'])->name('profile.sessions.logout-others');
    Route::delete('profile', [\App\Http\Controllers\AdminLte\ProfileController::class, 'destroy'])->name('profile.destroy');
});
