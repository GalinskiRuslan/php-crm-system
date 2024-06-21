<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('checkIsAdmin:admin')->get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::middleware('checkIsAdmin:admin')->post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::middleware('checkIsAdmin:admin')->delete('/categories', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::middleware('checkIsAdmin:admin')->get('/categories/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::middleware('checkIsAdmin:admin')->put('/category/{id}', [CategoryController::class, 'update'])->name('categories.update');

Route::middleware('checkIsAdmin:admin')->get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories');
Route::middleware('checkIsAdmin:admin')->post('/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
Route::middleware('checkIsAdmin:admin')->delete('/subcategories', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
Route::middleware('checkIsAdmin:admin')->get('/subcategories/{subcategory}', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
Route::middleware('checkIsAdmin:admin')->put('/subcategory/{id}', [SubcategoryController::class, 'update'])->name('subcategories.update');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login');
