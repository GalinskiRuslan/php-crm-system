<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\CategoryApiController;
use Illuminate\Support\Facades\Route;

//Routes for auth
Route::post('/auth/registration', [AuthApiController::class, 'registration']);
Route::get('/auth/getSms', [AuthApiController::class, 'getSmsCode']);
Route::middleware('auth:api')->get('/user', [AuthApiController::class, 'userInfo']);
Route::post('/auth/login', [AuthApiController::class, 'login'])->name('login');
Route::post('/auth/checkCode', [AuthApiController::class, 'checkCode']);
Route::post('/auth/resetPassword', [AuthApiController::class, 'resetPassword']);
Route::middleware(['jwt.auth', 'checkUserRole:admin'])->get('/hello', function () {
    return 'hello';
});

// Routes for categories

Route::get('/categories', [CategoryApiController::class, 'getAllCategories']);
