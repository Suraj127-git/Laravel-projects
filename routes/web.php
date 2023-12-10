<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/error', [MainController::class, 'error']);
Route::get('/success', [MainController::class, 'success']);

Route::post('/payment', [MainController::class, 'payment']);
Route::post('/pay', [MainController::class, 'pay']);


?>