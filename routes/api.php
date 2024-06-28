<?php

use App\Http\Controllers\api\AuthApiController;
use App\Http\Controllers\api\BrandsApiController;
use App\Http\Controllers\api\CategoryApiController;
use App\Http\Controllers\api\SubcategoryController;
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

Route::get('/categories', [CategoryApiController::class, 'getAllCategories']);
Route::get('/subcategories', [SubcategoryController::class, 'getAllSubcategories']);
Route::get('/brands', [BrandsApiController::class, 'getAllBrands']);
