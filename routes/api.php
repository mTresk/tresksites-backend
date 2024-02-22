<?php

use App\Http\Controllers\API\PolicyController;
use App\Http\Controllers\API\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('works', [WorkController::class, 'index']);
Route::get('works/featured', [WorkController::class, 'featured']);
Route::get('works/{work:slug}', [WorkController::class, 'show']);
Route::get('policy', [PolicyController::class, 'index']);


