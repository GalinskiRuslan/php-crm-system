<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [AuthController::class, 'register']);
Route::post('/verify', [AuthController::class, 'verify']);
Route::get('/hello', function () {
    return response()->json('hello', 200);
});
