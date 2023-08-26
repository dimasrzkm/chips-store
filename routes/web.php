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
use App\Livewire\RolesPermissions\ApplyRoles;
use App\Livewire\RolesPermissions\EditApplyPermissions;
use App\Livewire\RolesPermissions\EditApplyRoles;
use App\Livewire\RolesPermissions\ShowApplyPermission;
use App\Livewire\RolesPermissions\ShowApplyRoles;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ShowSuppliers;
use App\Livewire\Users\CreateUsers;
use App\Livewire\Users\EditUsers;
use App\Livewire\Users\ShowUsers;
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

    Route::group(['middleware' => ['role:pemilik']], function () {
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
            Route::get('permission/assignable', ShowApplyPermission::class)->name('assignable.index');
            Route::get('permission/create', ApplyPermissions::class)->name('assignable.create');
            Route::get('permission/{role:name}/edit', EditApplyPermissions::class)->name('assignable.edit');

            Route::get('role/assign', ShowApplyRoles::class)->name('assign.index');
            Route::get('role/create', ApplyRoles::class)->name('assign.create');
            Route::get('role/{user}/edit', EditApplyRoles::class)->name('assign.edit');
        });

        Route::get('users', ShowUsers::class)->name('users.index');
        Route::get('users/create', CreateUsers::class)->name('users.create');
        Route::get('users/{user}/edit', EditUsers::class)->name('users.edit');
    });

    Route::get('suppliers', ShowSuppliers::class)->name('suppliers.index')->middleware(['role:pemilik|bagian gudang']);
    Route::group(['middleware' => ['role:pemilik']], function () {
        Route::get('suppliers/create', CreateSupplier::class)->name('suppliers.create');
        Route::get('suppliers/{supplier:name}/edit', EditSupplier::class)->name('suppliers.edit');
    });
});
