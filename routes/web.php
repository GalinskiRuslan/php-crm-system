<?php

use App\Http\Controllers\AuthController;
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

Route::middleware('checkIsAdmin:admin')->get('/categories', [CategoryController::class, 'index']);
Route::middleware('checkIsAdmin:admin')->post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::middleware('checkIsAdmin:admin')->delete('/categories', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::middleware('checkIsAdmin:admin')->get('/categories/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::middleware('checkIsAdmin:admin')->put('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');


Route::middleware('checkIsAdmin: ')->put('/private', [CategoryController::class, 'update'])->name('categories.update');


Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
