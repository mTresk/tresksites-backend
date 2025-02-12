<?php

use App\Http\Controllers\API\AdvantageController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PolicyController;
use App\Http\Controllers\API\PriceController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('works', [WorkController::class, 'index']);
Route::get('works/featured', [WorkController::class, 'featured']);
Route::get('works/{work:slug}', [WorkController::class, 'show']);
Route::get('policy', [PolicyController::class, 'index']);
Route::post('orders', [OrderController::class, 'create']);
Route::get('contacts', [ContactController::class, 'index']);
Route::get('services', [ServiceController::class, 'index']);
Route::get('prices', [PriceController::class, 'index']);
Route::get('advantages', [AdvantageController::class, 'index']);
Route::get('routes', [WorkController::class, 'routes']);
Route::get('search', [SearchController::class, 'search']);
