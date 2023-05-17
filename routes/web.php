<?php

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

Route::get('/', [\App\Http\Controllers\ChartController::class, 'index'])->name('charts.index');
Route::post('/create-price-notification', [\App\Http\Controllers\ChartController::class, 'createPriceNotification'])->name('charts.create-price-notification');
