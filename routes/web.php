<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientOrdersController;
use App\Http\Controllers\DisplayMenuController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ManageOrdersController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\PizzasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TokensController;
use App\Http\Controllers\TranslationsController;
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

Route::resource('management/admin/statistics', StatisticsController::class)
    ->only(['index'])
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.admin.statistics.index',
    ]);

Route::get('management/admin/logs', [LogsController::class, 'index'])->name('management.admin.logs.index')
    ->middleware(['auth', 'role:admin']);
Route::get('management/admin/logs/{log}', [LogsController::class, 'show'])->name('management.admin.logs.show')
    ->middleware(['auth', 'role:admin']);

Route::resource('management/employee/ingredients', IngredientsController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.employee.ingredients.index',
        'create' => 'management.employee.ingredients.create',
        'store' => 'management.employee.ingredients.store',
        'show' => 'management.employee.ingredients.show',
        'edit' => 'management.employee.ingredients.edit',
        'update' => 'management.employee.ingredients.update',
        'destroy' => 'management.employee.ingredients.destroy',
    ]);
Route::resource('management/employee/pizzas', PizzasController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.employee.pizzas.index',
        'create' => 'management.employee.pizzas.create',
        'store' => 'management.employee.pizzas.store',
        'show' => 'management.employee.pizzas.show',
        'edit' => 'management.employee.pizzas.edit',
        'update' => 'management.employee.pizzas.update',
        'destroy' => 'management.employee.pizzas.destroy',
    ]);
Route::resource('management/employee/orders', ManageOrdersController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.employee.orders.index',
        'show' => 'management.employee.orders.show',
        'edit' => 'management.employee.orders.edit',
        'update' => 'management.employee.orders.update',
    ]);
Route::patch('management/employee/orders/{order}/status', [ManageOrdersController::class, 'updateStatus'])
    ->middleware(['auth', 'role:admin'])
    ->name('management.employee.orders.updateStatus');

Route::resource('management/employee/translations', TranslationsController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'index' => 'management.employee.translations.index',
        'show' => 'management.employee.translations.show',
        'edit' => 'management.employee.translations.edit',
        'create' => 'management.employee.translations.create',
        'store' => 'management.employee.translations.store',
        'update' => 'management.employee.translations.update',
    ]);


Route::resource('pizza', PizzaController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'create' => 'client.pizza.create',
        'edit' => 'client.pizza.edit',
    ]);


Route::resource('menu', DisplayMenuController::class)
    ->only(['index'])
    ->names([
        'index' => 'client.menu.index',
    ]);

Route::resource('orders', ClientOrdersController::class)
    ->middleware(['auth'])
    ->names([
        'index' => 'client.orders.index',
        'show' => 'client.orders.show',
    ]);
Route::patch('orders/{order}/cancel', [ClientOrdersController::class, 'cancelOrder'])
    ->middleware(['auth'])
    ->name('client.orders.cancelOrder');


Route::get('cart/{id}', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/{id}/order', [CartController::class, 'order'])->name('cart.order');

Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::resource('pizza', PizzaController::class)
    ->middleware(['auth', 'role:admin'])
    ->names([
        'create' => 'client.pizza.create',
        'store' => 'client.pizza.store',
        'edit' => 'client.pizza.edit',
        'update' => 'client.pizza.update',
    ]);

require __DIR__.'/auth.php';
