<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemPhotoController;
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

Route::middleware('checkIsAdmin:admin')->get('/brands', [BrandsController::class, 'index'])->name('brands');
Route::middleware('checkIsAdmin:admin')->post('/brands', [BrandsController::class, 'store'])->name('brands.store');
Route::middleware('checkIsAdmin:admin')->delete('/brands', [BrandsController::class, 'destroy'])->name('brands.destroy');
Route::middleware('checkIsAdmin:admin')->get('/brands/{brand}', [BrandsController::class, 'edit'])->name('brands.edit');
Route::middleware('checkIsAdmin:admin')->put('/brand/{id}', [BrandsController::class, 'update'])->name('brands.update');


Route::middleware('checkIsAdmin:admin')->get('/items', [ItemController::class, 'index'])->name('items');
Route::middleware('checkIsAdmin:admin')->post('/items', [ItemController::class, 'createNewItem'])->name('items.store');
Route::middleware('checkIsAdmin:admin')->delete('/items', [ItemController::class, 'deleteItem'])->name('item.destroy');
Route::middleware('checkIsAdmin:admin')->get('/items/{item}', [ItemController::class, 'editItem'])->name('item.edit');
Route::middleware('checkIsAdmin:admin')->put('/items/{id}', [ItemController::class, 'updateItem'])->name('item.update');
Route::middleware('checkIsAdmin:admin')->put('/items/moderate/{id}', [ItemController::class, 'moderateItem'])->name('item.moderate');
Route::middleware('checkIsAdmin:admin')->delete('/items/photo', [ItemPhotoController::class, 'deletePhoto'])->name('photo.destroy');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login');
