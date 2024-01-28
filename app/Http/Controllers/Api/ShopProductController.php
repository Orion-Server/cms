<?php

namespace App\Http\Controllers\Api;

use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopProductController extends Controller
{
    public function show(string $id)
    {
        $product = ShopProduct::with([
            'items' => fn ($query) => $query->where('is_active', true)
        ])->find($id);

        if (!$product) {
            return $this->jsonResponse([
                'message' => __('Product not found.')
            ], 404);
        }

        return $this->jsonResponse([
            'product' => $product
        ], 200);
    }
}
