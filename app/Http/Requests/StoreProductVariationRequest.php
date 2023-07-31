<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'variants' => 'required|array',
            'variants.*.title' => 'required',
            'variants.*.sku' => 'required',
            'variants.*.price' => 'nullable|integer',
            'variants.*.type' => 'required',
            'variants.*.parent_id' => 'nullable'
        ];
    }
}
