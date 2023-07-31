<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Http\Resources\Shop\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(CartInterface $cart)
    {
        return inertia()->render('Home', [
            'cart' => $cart,
            'products' => ProductResource::collection(
                Product::with('variants', 'media')->latest()->get()
            ),
        ]);
    }
}
