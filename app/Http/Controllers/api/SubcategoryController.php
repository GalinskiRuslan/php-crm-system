<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/subcategories",
     *  summary = "Получение всех подкатегорий",
     *  tags={"Shop"},
     * @OA\Response(
     *  response=200,
     *  description="successful operation",
     * ),
     *  )
     *
     */
    public function getAllSubcategories()
    {
        $subcategories = DB::table('subcategories')->join('categories', 'subcategories.category_id', '=', 'categories.id')->select('subcategories.*', 'categories.name as category_name')->get();
        return response()->json($subcategories);
    }
}
