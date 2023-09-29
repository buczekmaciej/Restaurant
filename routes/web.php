<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\OrderController;
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

Route::get('/worker', [WorkerOrderController::class, 'dashboard']);
