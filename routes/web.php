<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Worker\AuthController;
use App\Http\Controllers\Worker\DashboardController;
use App\Http\Controllers\Worker\EmployeesController;
use App\Http\Controllers\Worker\IngredientsController;
use App\Http\Controllers\Worker\LocationsController;
use App\Http\Controllers\Worker\MealsController;
use App\Http\Controllers\Worker\OrderController as WorkerOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AppController::class, 'homepage'])->name('homepage');
Route::get('/menu', [AppController::class, 'menu'])->name('menu');

Route::prefix('orders')->controller(OrderController::class)->name('order.')->group(function () {
    Route::get('/track/{order:code?}', 'track')->name('track');
    Route::post('/track/{order:code?}', 'track');
    Route::post('/new', 'create')->name('create');
    Route::post('/summary', 'summary')->name('summary');
    Route::post('/summary/finish', 'save')->name('save');
});

Route::prefix('staff')->name('staff.')->group(function () {
    Route::prefix('auth')->name('auth.')->controller(AuthController::class)->group(function () {
        Route::get('/login', 'loginView')->name('login');
        Route::post('/login', 'loginHandle');
        Route::get('/logout', 'logout')->name('logout')->middleware('auth');
    });

    Route::get('/working', [WorkerOrderController::class, 'working'])->name('working')->middleware('auth');

    Route::middleware('superiorstaff')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::prefix('ingredients')->name('ingredients.')->controller(IngredientsController::class)->group(function () {
            Route::get('/', 'view')->name('view');
            Route::get('/create', 'createView')->name('create');
            Route::post('/create', 'createHandle');
            Route::get('/{ingredient:name}', 'manage')->name('manage');
            Route::post('/{ingredient:name}/update', 'update')->name('update');
            Route::delete('/{ingredient:name}/delete', 'delete')->name('delete');
        });

        Route::get('/orders', [WorkerOrderController::class, 'view'])->name('orders.view');

        Route::prefix('meals')->name('meals.')->controller(MealsController::class)->group(function () {
            Route::get('/', 'view')->name('view');
            Route::get('/create', 'createView')->name('create');
            Route::post('/create', 'createHandle');
            Route::get('/{meal:name}', 'manage')->name('manage');
            Route::post('/{meal:name}/update', 'update')->name('update');
            Route::delete('/{meal:name}/delete', 'delete')->name('delete');
        });

        Route::prefix('locations')->name('locations.')->controller(LocationsController::class)->group(function () {
            Route::get('/', 'view')->name('view');
            Route::get('/create', 'createView')->name('create');
            Route::post('/create', 'createHandle');
            Route::get('/{location:id}', 'manage')->name('manage');
            Route::post('/{location:id}/update', 'update')->name('update');
            Route::delete('/{location:id}/delete', 'delete')->name('delete');
        });

        Route::prefix('employees')->name('employees.')->controller(EmployeesController::class)->group(function () {
            Route::get('/', 'view')->name('view');
            Route::get('/create', 'createView')->name('create');
            Route::post('/create', 'createHandle');
            Route::get('/{user:code}', 'manage')->name('manage');
            Route::post('/{user:code}/update', 'update')->name('update');
            Route::delete('/{user:code}/delete', 'delete')->name('delete');
        });
    });
});
