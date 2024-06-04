<?php

use App\Http\Controllers\api\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/registration', [AuthApiController::class, 'registration']);
Route::get('/auth/getSms', [AuthApiController::class, 'getSmsCode']);
Route::middleware('api')->get('/user', [AuthApiController::class, 'userInfo']);
Route::post('/auth/login', [AuthApiController::class, 'login'])->name('login');
Route::post('/auth/checkCode', [AuthApiController::class, 'checkCode']);
Route::get('/hello', function () {
    return response()->json('hello', 200);
});
