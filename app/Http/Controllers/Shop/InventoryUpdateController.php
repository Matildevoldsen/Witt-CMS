<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Inventory $inventory)
    {
        $inventory->title = $request->title;
        $inventory->name = $request->name;
        $inventory->price = $request->price;
        $inventory->quantity = $request->quantity;
        $inventory->delivery_fee = $request->delivery_fee;
        $inventory->sku = $request->sku;
        $inventory->description = $request->description;
        $inventory->additional_data = $request->additional_data;
        $inventory->images = $request->images;

        $inventory->save();

        return back()->with([
            'item' => $inventory,
        ]);
    }
}
