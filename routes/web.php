<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;

// Cukup pakai ini satu saja. Hapus yang Route::get('/', function... )
Route::get('/', [LandingPageController::class, 'index'])->name('home');