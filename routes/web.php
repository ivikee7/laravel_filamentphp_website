<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Homepage / Dynamic Frontpage
Route::get('/', [ContentController::class, 'home'])->name('home');

// 2. Directory Listing
Route::get('/content', [ContentController::class, 'index'])->name('content.index');

// 3. Single Content / Sub-pages
Route::match(['get', 'post'], '/content/{slug}', [ContentController::class, 'show'])->name('content.show');
