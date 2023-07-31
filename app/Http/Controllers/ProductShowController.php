<?php

namespace App\Http\Controllers;

use App\Http\Resources\Shop\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        return inertia()->render('Products/Index', [
            'product' => ProductResource::make($product->load('variants', 'media'))
        ]);
    }
}
