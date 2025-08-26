<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DefinitionsController;
use App\Http\Controllers\EndOfDayController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
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
    Route::post('/endofdays/delete', [EndOfDayController::class, 'delete']);

    Route::post('/reports/getReportData', [ReportController::class, 'getReportData']);
    Route::post('/reports/createReport', [ReportController::class, 'createReport']);

    Route::post('/guess/getData', [GuessController::class, 'getData']);

    Route::post('/profile/updateProfile', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword']);

    Route::post('/users/addUser', [UserController::class, 'addUser']);
    Route::post('/users/getUsers', [UserController::class, 'getUsers']);
    
});
