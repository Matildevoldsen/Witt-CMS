<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaveProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id . '|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'live_at' => 'required|date',
        ]);

        $product->title = $request->input('title');
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->live_at = Carbon::parse($request->input('live_at'));
        $product->save();

        return response()->json(['product' => $product], 200);
    }
}
