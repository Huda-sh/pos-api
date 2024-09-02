<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () { //TODO: add admin middleware

    Route::apiResource('user', UserController::class)->middleware(AdminMiddleware::class);

    Route::apiResource('product', ProductController::class);

    Route::apiResource('category', CategoryController::class)->except('show');

    Route::apiResource('bill', BillController::class);

    Route::delete('logout', [AuthController::class, 'logout']);

});

// Route::controller()
// TODO: add pos routes
