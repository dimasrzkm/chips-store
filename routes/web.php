<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Pages\Admin;
use App\Livewire\Permissions\CreatePermissions;
use App\Livewire\Permissions\EditPermissions;
use App\Livewire\Permissions\ShowPermissions;
use App\Livewire\Profile\ProfileInformation;
use App\Livewire\Roles\CreateRoles;
use App\Livewire\Roles\EditRoles;
use App\Livewire\Roles\ShowRoles;
use App\Livewire\RolesPermissions\ApplyPermissions;
use App\Livewire\RolesPermissions\EditApplyPermissions;
use App\Livewire\RolesPermissions\ShowApplyPermission;
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

    Route::prefix('roles')->group(function () {
        Route::get('', ShowRoles::class)->name('roles.index');
        Route::get('create', CreateRoles::class)->name('roles.create');
        Route::get('{role:name}/edit', EditRoles::class)->name('roles.edit');
    });

    Route::prefix('role-and-permission')->group(function () {
        Route::get('assignable', ShowApplyPermission::class)->name('assignable.index');
        Route::get('create', ApplyPermissions::class)->name('assignable.create');
        Route::get('{role:name}/edit', EditApplyPermissions::class)->name('assignable.edit');
    });
});
