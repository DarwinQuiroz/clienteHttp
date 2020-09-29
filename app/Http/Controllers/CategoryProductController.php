<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function showProductsCategory($title, $id)
    {
        $products = $this->marketService->getCategoryProducts($id);

        return view('categories.products.show')->with([
            'products' => $products
        ]);
    }
}
