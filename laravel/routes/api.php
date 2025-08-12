<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiTokenController;
use App\Http\Controllers\Api\V1\ExternalController;
use App\Http\Controllers\Api\V1\UserController;

Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

Route::post('token', [ApiTokenController::class, 'generateToken']);
Route::get('external', ExternalController::class);

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);
    });
