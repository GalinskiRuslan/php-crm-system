<?php

use App\Http\Controllers\api\AuthApiController;
use Illuminate\Support\Facades\Route;

// Route::post('/registration', [AuthController::class, 'register']);
Route::get('/auth/getSms', [AuthApiController::class, 'getSmsCode']);
// Route::post('/verify', [AuthController::class, 'verify']);
Route::get('/hello', function () {
    return response()->json('hello', 200);
});
Route::get('/hello/foo', function () {
    return response()->json('awfdwaaf', 200);
});
Route::post('/hello/bar', function () {
    return response()->json('awfdwaaf', 200);
});
