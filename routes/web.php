<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/register', [AuthController::class, 'showRegisterForm']);
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::get('/verify', [AuthController::class, 'showVerifyForm']);
// Route::post('/verify', [AuthController::class, 'verify']);
// Route::get('/hello', function () {
//     return 'hello';
// });
Route::get('/', function () {
    return view('welcome');
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::delete('/categories', [CategoryController::class, 'destroy'])->name('categories.destroy');
