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
    // [adminlte:roles]
    Route::get('roles', [\App\Http\Controllers\AdminLte\RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [\App\Http\Controllers\AdminLte\RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [\App\Http\Controllers\AdminLte\RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [\App\Http\Controllers\AdminLte\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [\App\Http\Controllers\AdminLte\RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [\App\Http\Controllers\AdminLte\RoleController::class, 'destroy'])->name('roles.destroy');

    // [adminlte:users]
    Route::get('users', [\App\Http\Controllers\AdminLte\UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [\App\Http\Controllers\AdminLte\UserController::class, 'create'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\AdminLte\UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [\App\Http\Controllers\AdminLte\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [\App\Http\Controllers\AdminLte\UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [\App\Http\Controllers\AdminLte\UserController::class, 'destroy'])->name('users.destroy');

    // [adminlte:notifications]
    Route::get('notifications', [\App\Http\Controllers\AdminLte\NotificationController::class, 'index'])->name('notifications.index');
    Route::put('notifications/read-all', [\App\Http\Controllers\AdminLte\NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::put('notifications/{id}/read', [\App\Http\Controllers\AdminLte\NotificationController::class, 'read'])->name('notifications.read');
    Route::delete('notifications/{id}', [\App\Http\Controllers\AdminLte\NotificationController::class, 'destroy'])->name('notifications.destroy');

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
