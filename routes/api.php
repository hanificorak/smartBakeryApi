<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DefinitionsController;
use App\Http\Controllers\EndOfDayController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('/products/getData', [DefinitionsController::class, 'getProducts']);
    Route::post('/products/addProduct', [DefinitionsController::class, 'addProduct']);
    Route::post('/products/productDelete', [DefinitionsController::class, 'productDelete']);

    Route::post('/stocks/getParam', [StockController::class, 'getParam']);
    Route::post('/stocks/getWeatherItem', [StockController::class, 'getWeatherItem']);
    Route::post('/stocks/saveStock', [StockController::class, 'saveStock']);
    Route::post('/stocks/getStockData', [StockController::class, 'getStockData']);
    Route::post('/stocks/stockDelete', [StockController::class, 'stockDelete']);

    Route::post('/endofdays/getEndOfListData', [EndOfDayController::class, 'getEndOfListData']);
    Route::post('/endofdays/addEndOfData', [EndOfDayController::class, 'addEndOfData']);
    Route::post('/endofdays/endOfDataCheck', [EndOfDayController::class, 'endOfDataCheck']);
    Route::post('/endofdays/getEndOfData', [EndOfDayController::class, 'getEndOfData']);
});
