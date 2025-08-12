<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiTokenController;
use App\Http\Controllers\Api\V1\UserController;

Route::post('v1/token', [ApiTokenController::class, 'generateToken']);

Route::middleware('auth:sanctum')->prefix('v1')
    ->group(function () {
        Route::apiResource('users', UserController::class);
    });
