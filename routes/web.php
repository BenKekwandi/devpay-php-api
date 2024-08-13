<?php

use App\Http\Controllers\AccountGroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'appName'=> env('APP_NAME'),
        'environment' => env('APP_ENV'),
        'date' => date('Y-m-d - H:i:s'),
        'timezone'=> date_default_timezone_get()
    ]);
});

