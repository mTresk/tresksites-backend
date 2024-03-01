<?php

use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PolicyController;
use App\Http\Controllers\API\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('works', [WorkController::class, 'index']);
Route::get('routes', [WorkController::class, 'routes']);
Route::get('works/featured', [WorkController::class, 'featured']);
Route::get('works/{work:slug}', [WorkController::class, 'show']);
Route::get('policy', [PolicyController::class, 'index']);
Route::post('order', [OrderController::class, 'create']);
Route::get('contacts', [ContactController::class, 'index']);


