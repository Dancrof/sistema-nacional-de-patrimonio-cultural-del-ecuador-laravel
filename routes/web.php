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
    // [adminlte:dashboard]
    Route::get('dashboard', [\App\Http\Controllers\AdminLte\DashboardController::class, 'index'])->name('dashboard');

    // [adminlte:roles]
    Route::get('roles', [\App\Http\Controllers\AdminLte\RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [\App\Http\Controllers\AdminLte\RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [\App\Http\Controllers\AdminLte\RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [\App\Http\Controllers\AdminLte\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [\App\Http\Controllers\AdminLte\RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [\App\Http\Controllers\AdminLte\RoleController::class, 'destroy'])->name('roles.destroy');

    // [adminlte:catalogs]
    Route::get('categories', [\App\Http\Controllers\AdminLte\CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [\App\Http\Controllers\AdminLte\CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [\App\Http\Controllers\AdminLte\CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [\App\Http\Controllers\AdminLte\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [\App\Http\Controllers\AdminLte\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [\App\Http\Controllers\AdminLte\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('artwork-types', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'index'])->name('artwork-types.index');
    Route::get('artwork-types/create', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'create'])->name('artwork-types.create');
    Route::post('artwork-types', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'store'])->name('artwork-types.store');
    Route::get('artwork-types/{artworkType}/edit', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'edit'])->name('artwork-types.edit');
    Route::put('artwork-types/{artworkType}', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'update'])->name('artwork-types.update');
    Route::delete('artwork-types/{artworkType}', [\App\Http\Controllers\AdminLte\ArtworkTypeController::class, 'destroy'])->name('artwork-types.destroy');

    Route::get('conservation-statuses', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'index'])->name('conservation-statuses.index');
    Route::get('conservation-statuses/create', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'create'])->name('conservation-statuses.create');
    Route::post('conservation-statuses', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'store'])->name('conservation-statuses.store');
    Route::get('conservation-statuses/{conservationStatus}/edit', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'edit'])->name('conservation-statuses.edit');
    Route::put('conservation-statuses/{conservationStatus}', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'update'])->name('conservation-statuses.update');
    Route::delete('conservation-statuses/{conservationStatus}', [\App\Http\Controllers\AdminLte\ConservationStatusController::class, 'destroy'])->name('conservation-statuses.destroy');

    // [adminlte:geography]
    Route::get('provinces', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'index'])->name('provinces.index');
    Route::get('provinces/create', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'create'])->name('provinces.create');
    Route::post('provinces', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'store'])->name('provinces.store');
    Route::get('provinces/{province}/edit', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'edit'])->name('provinces.edit');
    Route::put('provinces/{province}', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'update'])->name('provinces.update');
    Route::delete('provinces/{province}', [\App\Http\Controllers\AdminLte\ProvinceController::class, 'destroy'])->name('provinces.destroy');

    Route::get('cantons', [\App\Http\Controllers\AdminLte\CantonController::class, 'index'])->name('cantons.index');
    Route::get('cantons/create', [\App\Http\Controllers\AdminLte\CantonController::class, 'create'])->name('cantons.create');
    Route::post('cantons', [\App\Http\Controllers\AdminLte\CantonController::class, 'store'])->name('cantons.store');
    Route::get('cantons/{canton}/edit', [\App\Http\Controllers\AdminLte\CantonController::class, 'edit'])->name('cantons.edit');
    Route::put('cantons/{canton}', [\App\Http\Controllers\AdminLte\CantonController::class, 'update'])->name('cantons.update');
    Route::delete('cantons/{canton}', [\App\Http\Controllers\AdminLte\CantonController::class, 'destroy'])->name('cantons.destroy');

    Route::get('parishes', [\App\Http\Controllers\AdminLte\ParishController::class, 'index'])->name('parishes.index');
    Route::get('parishes/create', [\App\Http\Controllers\AdminLte\ParishController::class, 'create'])->name('parishes.create');
    Route::post('parishes', [\App\Http\Controllers\AdminLte\ParishController::class, 'store'])->name('parishes.store');
    Route::get('parishes/{parish}/edit', [\App\Http\Controllers\AdminLte\ParishController::class, 'edit'])->name('parishes.edit');
    Route::put('parishes/{parish}', [\App\Http\Controllers\AdminLte\ParishController::class, 'update'])->name('parishes.update');
    Route::delete('parishes/{parish}', [\App\Http\Controllers\AdminLte\ParishController::class, 'destroy'])->name('parishes.destroy');

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
