<?php
use Illuminate\Support\Facades\Route;
use Sara\SaraAuth\Http\Controllers\AuthController;
use Sara\SaraAuth\Http\Middleware\AuthenticateToken;

Route::prefix('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware([AuthenticateToken::class])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});
