<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShowPriceController;

Route::get('/show-price', [ShowPriceController::class, 'showPrice']);
Route::middleware(['web', 'auth'])->post('/show-price', [ShowPriceController::class, 'updateFavourite']);
