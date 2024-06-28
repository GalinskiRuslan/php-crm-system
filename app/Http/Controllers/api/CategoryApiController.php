<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/categories",
     *  summary = "Получение всех категорий",
     *  tags={"Shop"},
     * @OA\Response(
     *  response=200,
     *  description="successful operation",
     * ),
     *  )
     *
     */
    public function getAllCategories()
    {
        return response()->json(Category::all());
    }
}
