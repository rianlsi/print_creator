<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::all();
        return view('products.list', ['products' => $products]);

    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.detail', ['product' => $product]);
    }

    public function jlist()
    {
        $products = Product::all();

        $formattedProducts = $products->map(function ($product) {
            return [
                'code' => $product->zakeke_product_id,
                'name' => $product->name,
                'thumbnail' => env('APP_URL') . '/storage/products/' . $product->thumbnail,
            ];
        });

        return response()->json($formattedProducts);
    }
}
