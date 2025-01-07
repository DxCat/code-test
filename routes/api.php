<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\QueryController;
use Illuminate\Support\Facades\Route;

Route::post('/distribute', [CardController::class, 'distribute']);
Route::get('/original-query', [QueryController::class, 'originalQuery']);
Route::get('/new-query', [QueryController::class, 'newQuery']);
