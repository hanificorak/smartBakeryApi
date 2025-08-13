<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DefinitionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('/products/getData', [DefinitionsController::class, 'getProducts']);
    Route::post('/products/addProduct', [DefinitionsController::class, 'addProduct']);
    Route::post('/products/productDelete', [DefinitionsController::class, 'productDelete']);
});