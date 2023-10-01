<?php

use App\Livewire\Pages\Admin;
use App\Livewire\Roles\EditRoles;
use App\Livewire\Roles\ShowRoles;
use App\Livewire\Units\EditUnits;
use App\Livewire\Units\ShowUnits;
use App\Livewire\Users\EditUsers;
use App\Livewire\Users\ShowUsers;
use App\Livewire\Roles\CreateRoles;
use App\Livewire\Stocks\EditStocks;
use App\Livewire\Stocks\ShowStocks;
use App\Livewire\Units\CreateUnits;
use App\Livewire\Users\CreateUsers;
use App\Livewire\Stocks\CreateStocks;
use Illuminate\Support\Facades\Route;
use App\Livewire\Expenses\ShowExpenses;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Livewire\Sellings\ShowSellings;
use App\Livewire\Suppliers\EditSupplier;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Livewire\Expenses\CreateExpenses;
use App\Livewire\Products\CreateProducts;
use App\Livewire\Sellings\CreateSellings;
use App\Livewire\Suppliers\ShowSuppliers;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Konsinyors\EditKonsinyors;
use App\Livewire\Konsinyors\ShowKonsinyors;
use App\Livewire\Profile\ProfileInformation;
use App\Livewire\Consigments\ShowConsigments;
use App\Livewire\Konsinyors\CreateKonsinyors;
use App\Livewire\Permissions\EditPermissions;
use App\Livewire\Permissions\ShowPermissions;
use App\Livewire\ReportsSellingsShowSellings;
use App\Livewire\RolesPermissions\ApplyRoles;
use App\Livewire\Consigments\CreateConsigments;
use App\Livewire\Permissions\CreatePermissions;
use App\Livewire\RolesPermissions\EditApplyRoles;
use App\Livewire\RolesPermissions\ShowApplyRoles;
use App\Livewire\RolesPermissions\ApplyPermissions;
use App\Livewire\Reports\Sellings\ShowReportSellings;
use App\Livewire\RolesPermissions\ShowApplyPermission;
use App\Livewire\RolesPermissions\EditApplyPermissions;

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

    Route::group(['middleware' => ['role:pemilik|bagian gudang']], function () {
        Route::get('suppliers', ShowSuppliers::class)->name('suppliers.index');
        Route::get('suppliers/create', CreateSupplier::class)->name('suppliers.create');
        Route::get('suppliers/{supplier:name}/edit', EditSupplier::class)->name('suppliers.edit');
    });

    Route::get('konsinyors', ShowKonsinyors::class)->name('konsinyors.index')->middleware(['role:pemilik|bagian gudang']);
    Route::group(['middleware' => ['role:pemilik']], function () {
        Route::get('konsinyors/create', CreateKonsinyors::class)->name('konsinyors.create');
        Route::get('konsinyors/{konsinyor:name}/edit', EditKonsinyors::class)->name('konsinyors.edit');
    });

    Route::group(['middleware' => ['role:pemilik|bagian gudang']], function () {
        Route::get('stocks', ShowStocks::class)->name('stocks.index');
        Route::get('stocks/create', CreateStocks::class)->name('stocks.create');
        Route::get('stocks/{stock:id}/edit', EditStocks::class)->name('stocks.edit');
    });

    Route::get('products', ShowProducts::class)->name('products.index')->middleware(['role:pemilik|bagian gudang|kasir']);
    Route::group(['middleware' => ['role:pemilik|bagian gudang']], function () {
        Route::get('products/create', CreateProducts::class)->name('products.create');
        Route::get('products/{product:name}/edit', EditProducts::class)->name('products.edit');
    });

    Route::group(['middleware' => ['role:pemilik|bagian gudang']], function () {
        Route::get('expenses', ShowExpenses::class)->name('expenses.index');
        Route::get('expenses/create', CreateExpenses::class)->name('expenses.create');

        Route::get('consigments', ShowConsigments::class)->name('consigments.index');
        Route::get('consigments/create', CreateConsigments::class)->name('consigments.create');

        Route::get('units', ShowUnits::class)->name('units.index');
        Route::get('units/create', CreateUnits::class)->name('units.create');
        Route::get('units/{unit:name}/edit', EditUnits::class)->name('units.edit');
    });

    Route::group(['middleware' => ['role:pemilik|kasir']], function () {
        Route::get('sellings', ShowSellings::class)->name('sellings.index');
        Route::get('sellings/create', CreateSellings::class)->name('sellings.create');
    });

    Route::prefix('reports')->group(function () {
        Route::get('sellings', ShowReportSellings::class)->name('reports.sellings.index');
    });
});
