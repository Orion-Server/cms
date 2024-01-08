<?php

namespace App\Http\Controllers;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $categories = ShopCategory::all();

        return view('pages.shop.index', compact('categories'));
    }
}
