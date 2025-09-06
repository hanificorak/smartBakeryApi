<?php

use App\Http\Classes\HolidayClass;
use App\Http\Classes\LastStockClass;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomOrderReportController;
use App\Http\Controllers\CustomOrdersController;
use App\Http\Controllers\DefinitionsController;
use App\Http\Controllers\EndOfDayController;
use App\Http\Controllers\FreezerController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LastStockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReinstallController;
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
    Route::post('/guess/totalGuessPdfMail', [GuessController::class, 'totalGuessPdfMail']);

    Route::post('/profile/updateProfile', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/updatePassword', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/getProfileData', [ProfileController::class, 'getProfileData']);

    Route::post('/users/addUser', [UserController::class, 'addUser']);
    Route::post('/users/getUsers', [UserController::class, 'getUsers']);
    Route::post('/users/getWaitData', [UserController::class, 'getWaitData']);
    Route::post('/users/approve', [UserController::class, 'approve']);

    Route::post('/company/getData', [CompanyController::class, 'getData']);
    Route::post('/company/save', [CompanyController::class, 'save']);

    Route::post('/reinstall/start', [ReinstallController::class, 'start']);
    Route::post('/user/userChange', [AuthController::class, 'userChange']);

    Route::post('/freezer/getData', [FreezerController::class, 'getData']);
    Route::post('/freezer/save', [FreezerController::class, 'save']);
    Route::post('/freezer/delete', [FreezerController::class, 'delete']);
    Route::post('/freezer/createReport', [FreezerController::class, 'createReport']);

    Route::post('/laststock/getData', [LastStockController::class, 'getData']);
    Route::post('/laststock/save', [LastStockController::class, 'save']);

    Route::post('/holidays/getData', [HolidayController::class, 'getData']);
    Route::post('/holidays/add', [HolidayController::class, 'add']);
    Route::post('/holidays/delete', [HolidayController::class, 'delete']);

    Route::post('/customorders/getCustomOrders', [CustomOrdersController::class, 'getCustomOrders']);
    Route::post('/customorders/add', [CustomOrdersController::class, 'add']);
    Route::post('/customorders/delete', [CustomOrdersController::class, 'delete']);

    Route::post('/customordersReport/getReportData', [CustomOrderReportController::class, 'getReportData']);
    Route::post('/customordersReport/createReportMail', [CustomOrderReportController::class, 'createReportMail']);


});
