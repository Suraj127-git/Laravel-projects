<?php

use App\Http\Controllers\RedirectController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\InstamojoController;
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
Route::get('/paypal_pay', [PaypalController::class, 'payment_response'])->name('paypal_success');

//Stripe
Route::post('/stripe_payment', [StripeController::class, 'payment_request'])->name('stripe_payment');
Route::get('/stripe_pay', [StripeController::class, 'payment_response'])->name('stripe_success');

//Instamojo
Route::post('instamojo_payment', [InstamojoController::class, 'payment_request'])->name('instamojo_payment');
Route::get('instamojo_pay', [InstamojoController::class, 'payment_response'])->name('instamojo_success');

?>