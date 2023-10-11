<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Consigments\CreateConsigments;
use App\Livewire\Consigments\ShowConsigments;
use App\Livewire\Expenses\CreateExpenses;
use App\Livewire\Expenses\ShowExpenses;
use App\Livewire\Konsinyors\CreateKonsinyors;
use App\Livewire\Konsinyors\EditKonsinyors;
use App\Livewire\Konsinyors\ShowKonsinyors;
use App\Livewire\Pages\Admin;
use App\Livewire\Permissions\ShowPermissions;
use App\Livewire\Products\CreateProducts;
use App\Livewire\Products\EditProducts;
use App\Livewire\Products\ShowProducts;
use App\Livewire\Profile\ProfileInformation;
use App\Livewire\Reports\Consigments\ShowReportConsigments;
use App\Livewire\Reports\Sellings\ShowReportSellings;
use App\Livewire\Reports\Stocks\ShowReportStocks;
use App\Livewire\Roles\ShowRoles;
use App\Livewire\RolesPermissions\ApplyRoles;
use App\Livewire\RolesPermissions\EditApplyRoles;
use App\Livewire\RolesPermissions\ShowApplyPermission;
use App\Livewire\RolesPermissions\ShowApplyRoles;
use App\Livewire\Sellings\CreateSellings;
use App\Livewire\Sellings\ShowSellings;
use App\Livewire\Stocks\CreateStocks;
use App\Livewire\Stocks\EditStocks;
use App\Livewire\Stocks\ShowStocks;
use App\Livewire\Suppliers\CreateSupplier;
use App\Livewire\Suppliers\EditSupplier;
use App\Livewire\Suppliers\ShowSuppliers;
use App\Livewire\Units\CreateUnits;
use App\Livewire\Units\EditUnits;
use App\Livewire\Units\ShowUnits;
use App\Livewire\Users\CreateUsers;
use App\Livewire\Users\EditUsers;
use App\Livewire\Users\ShowUsers;
use App\Models\Receipt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
        Route::get('permissions', ShowPermissions::class)->name('permissions.index');
        Route::get('roles', ShowRoles::class)->name('roles.index');

        Route::prefix('role-and-permission')->group(function () {
            Route::get('permission/assignable', ShowApplyPermission::class)->name('assignable.index');

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
        Route::get('sellings', ShowReportSellings::class)->name('reports.sellings.index')->middleware(['role:pemilik|kasir']);
        Route::group(['middleware' => 'role:pemilik|bagian gudang'], function () {
            Route::get('stocks', ShowReportStocks::class)->name('reports.stocks.index')->middleware(['role:pemilik|bagian gudang']);
            Route::get('consigments', ShowReportConsigments::class)->name('reports.consigments.index');
        });
    });

});

Route::get('/receipts/{receipt:name}', function (Receipt $receipt) {
    return Storage::response('public/receipts/'.$receipt->name);
});
