<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailablePermissionController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\OAuthUserController;
use App\Http\Controllers\Api\OtpAuthController;
use App\Http\Controllers\Api\SystemAccessController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/otp/request', [OtpAuthController::class, 'request']);
Route::post('/auth/otp/verify', [OtpAuthController::class, 'verify']);

Route::middleware('auth:api')->group(function (): void {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/me', MeController::class);
    Route::get('/my-systems', [SystemAccessController::class, 'index']);
    Route::post('/system-access/check', [SystemAccessController::class, 'check']);
    Route::post('/systems/{system:code}/permissions', [AvailablePermissionController::class, 'register']);
    
    // The new OAuth SSO system
    Route::get('/oauth/me', [OAuthUserController::class, 'me']);
    Route::get('/oauth/sessions', [\App\Http\Controllers\Api\OAuthSessionController::class, 'index']);
    Route::delete('/oauth/sessions/{tokenId}', [\App\Http\Controllers\Api\OAuthSessionController::class, 'destroy']);
});
