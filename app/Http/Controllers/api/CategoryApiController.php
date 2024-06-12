<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function getAllCategories()
    {
        return response()->json(Category::all());
    }
}
