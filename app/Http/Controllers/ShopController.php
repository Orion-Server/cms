<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private const PRODUCTS_LIST_LIMIT = 10;

    public function index(Request $request, ?string $currentCategoryId = null): View
    {
        $categories = ShopCategory::all();
        $products = ShopProduct::active(considerRank: false)->latest();
        $featuredProducts = ShopProduct::active()->featured()->get();

        if($currentCategoryId) {
            $products->whereCategoryId($currentCategoryId);
        }

        $products = $products->paginate(self::PRODUCTS_LIST_LIMIT)->fragment('products');

        return view('pages.shop.index', compact('categories', 'featuredProducts', 'products', 'currentCategoryId'));
    }
}
