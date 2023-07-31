<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UploadProductImageController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function __invoke(Request $request, Product $product)
    {
        $request->validate([
            'file.*' => 'required|image|max:10240', // validation for multiple image upload
        ]);

        $filePaths = [];

        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $mediaItem = $product
                    ->addMedia($file)
                    ->toMediaCollection('product-images');

                $filePaths[] = $mediaItem->getUrl('webp');
            }
        }

        return response()->json([
            'file_paths' => $filePaths,
        ], 201);
    }

}
