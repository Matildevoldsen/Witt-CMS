<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariationRequest;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariantStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreProductVariationRequest $request)
    {
        foreach ($request['variants'] as $order => $variant) {
            $variantInstance = $this->createVariant($variant, $request['product_id'], $order);

            if (isset($variant['children'])) {
                foreach ($variant['children'] as $childOrder => $childVariant) {
                    $this->createVariant($childVariant, $request['product_id'], $childOrder, $variantInstance->id);
                }
            }
        }

        return response()->json(['message' => 'Product Variations stored successfully'], 200);
    }


    protected function createVariant($variant, $productId, $order, $parentId = null): ProductVariation
    {
        $variantInstance = ProductVariation::make();
        $variantInstance->title = $variant['title'];
        $variantInstance->order = $order;
        $variantInstance->product_id = $productId;
        $variantInstance->price = $variant['price'];
        $variantInstance->sku = $variant['sku'];
        $variantInstance->type = $variant['type'];
        $variantInstance->parent_id = $parentId;
        $variantInstance->save();

        return $variantInstance;
    }
}
