<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Pages\Admin;
use App\Livewire\Permissions\CreatePermissions;
use App\Livewire\Permissions\EditPermissions;
use App\Livewire\Permissions\ShowPermissions;
use App\Livewire\Profile\ProfileInformation;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('dashboard', Admin::class)->name('dashboard');
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('profile/{user}', ProfileInformation::class)->name('profile');

    Route::prefix('permissions')->group(function () {
        Route::get('', ShowPermissions::class)->name('permissions.index');
        Route::get('create', CreatePermissions::class)->name('permissions.create');
        Route::get('{permission:name}/edit', EditPermissions::class)->name('permissions.edit');
    });
});
