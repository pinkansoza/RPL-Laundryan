<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PemesananController;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::post('/order', [PemesananController::class, 'store'])->name('order.store');