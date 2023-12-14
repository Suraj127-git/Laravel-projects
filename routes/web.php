<?php

use App\Http\Controllers\RedirectController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

//Redirect
Route::get('/', [RedirectController::class, 'index'])->name('home');
Route::get('/error', [RedirectController::class, 'error'])->name('error');
Route::get('/success', [RedirectController::class, 'success'])->name('success');

//Razorpay
Route::post('/razorpay_payment', [RazorpayController::class, 'payment_request'])->name('razorpay_payment');
Route::post('/razorpay_pay', [RazorpayController::class, 'payment_response'])->name('razorpay_success');

//Paypal
Route::post('/paypal_payment', [PaypalController::class, 'payment_request'])->name('paypal_payment');
Route::post('/paypal_pay', [PaypalController::class, 'payment_response'])->name('paypal_success');

?>