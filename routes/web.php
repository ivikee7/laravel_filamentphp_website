<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;

Route::get('/', function () {
    return view('welcome');
});

// Home Page (Fetches is_frontpage content via HomeController)
Route::get('/', HomeController::class)->name('home');

// Content Routes
Route::prefix('content')->name('content.')->group(function () {
    Route::get('/', [ContentController::class, 'index'])->name('index');
    Route::get('/{content:slug}', [ContentController::class, 'show'])->name('show');
});
