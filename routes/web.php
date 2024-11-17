<?php

use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TokensController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'pl'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('set-locale');

Route::resource('management/admin/pizzeria', ManagementController::class)
    ->only(['index', 'edit', 'update'])
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.admin.pizzeria.index',
        'edit' => 'management.admin.pizzeria.edit',
        'update' => 'management.admin.pizzeria.update',
    ])
    ->parameters([
        'pizzeria' => 'pizzeria',
    ]);

Route::resource('management/admin/tokens', TokensController::class)
    ->only(['index', 'create', 'store', 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.admin.tokens.index',
        'create' => 'management.admin.tokens.create',
        'store' => 'management.admin.tokens.store',
        'destroy' => 'management.admin.tokens.destroy',
    ]);

Route::resource('management/admin/employees', EmployeesController::class)
    ->only(['index', 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->names([
       'index' => 'management.admin.employees.index',
       'destroy' => 'management.admin.employees.destroy',
    ]);



require __DIR__.'/auth.php';
