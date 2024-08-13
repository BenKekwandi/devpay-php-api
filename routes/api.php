<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AccountPaymentMethodController;
use App\Http\Controllers\AccountGroupController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'date' => date('Y-m-d - H:i:s'),
        'timezone' => date_default_timezone_get()
    ]);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', ['as' => 'login', 'uses' => AuthController::class . '@login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', AuthController::class . '@me');
    Route::get('logout', AuthController::class . '@logout');

    Route::apiResource('user', UserController::class);
    Route::apiResource('account', AccountController::class);
    Route::apiResource('account_group', AccountGroupController::class);
    Route::apiResource('payment_method', PaymentMethodController::class);
    Route::apiResource('account_payment_method', AccountPaymentMethodController::class);

    Route::patch('user/me/change_password', UserController::class . '@me');
    Route::patch('user/{user}/change_password', UserController::class . '@change_password');
});
