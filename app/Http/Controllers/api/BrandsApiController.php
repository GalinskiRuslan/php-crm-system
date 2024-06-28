<?php

namespace App\Http\Controllers\api;

use App\Models\Brands;

class BrandsApiController
{
    /**
     * @OA\Get(
     *  path="/api/brands",
     *  summary = "Получение всех брэндов",
     *  tags={"Shop"},
     * @OA\Response(
     *  response=200,
     *  description="successful operation",
     * ),
     *  )
     *
     */
    public function getAllBrands()
    {
        $brands = Brands::all();
        return response()->json($brands);
    }
}
