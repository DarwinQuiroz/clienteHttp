<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MarketService;

class ProductController extends Controller
{
    public function __construct(MarketService $marketService)
    {
        $this->middleware('auth')->except(['showProduct']);
        parent::__construct($marketService);
    }

    public function showProduct($title, $id)
    {
        $product = $this->marketService->getProduct($id);

        return view('products.show')->with([
            'product' => $product
        ]);
    }

    public function purchaseProduct(Request $request, $title, $id)
    {
        $this->marketService->purchaseProduct($id, $request->user()->service_id, 1);

        return redirect()->route('products.show', [$title, $id])
        ->with('success', ['Producto comprado satisfactoriamente']);
    }

    public function showPublishProductForm()
    {
        $categories = $this->marketService->getCategories();

        return view('products.publish')->with([
            'categories' => $categories
        ]);
    }

    public function publishProduct(Request $request)
    {
        $rules = [
            'title' => 'required',
            'details' => 'required',
            'stock' => 'required|min:1',
            'picture' => 'required|image',
            'category' => 'required'
        ];

        $productData = $this->validate($request, $rules);
        $productData['picture'] = fopen($request->picture->path(), 'r');

        $productData = $this->marketService->publishProduct($request->user()->service_id, $productData);
        $this->marketService->setProductCategory($productData->identifier, $request->category);
        $this->marketService->updateProduct($request->user()->service_id, $productData->identifier, ['situation' => 'available']);

        return redirect()->route('products.show', [$productData->title, $productData->identifier])
        ->with('success', ['Producto publicado satisfactoriamente']);
    }
}
