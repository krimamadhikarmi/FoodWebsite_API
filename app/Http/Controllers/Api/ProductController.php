<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        if ($products->count() > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message' => 'No record found'], 200);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        //image handling through api
        if ($request->has('image')) {
            $image = $request->image;

            if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
                $image = substr($image, strpos($image, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
                $image = base64_decode($image);
                $filename = time() . '.' . $type;
                $folder = storage_path('app/public/products');
                if (!file_exists($folder)) {
                    mkdir($folder, 0755, true);
                }

                file_put_contents($folder . '/' . $filename, $image);
                $validated['image'] = 'products/' . $filename;
            }

        }


        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product Created Successfully',
            'data' => $product
        ], 201);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);

    }

    public function update(Product $product, Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'ingredients' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        if ($request->has('image')) {
            $image = $request->image;
            if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
                $image = substr($image, strpos($image, ',') + 1);
                $type = strtolower($type[1]);
                $image = base64_decode($image);
                $filename = time() . '.' . $type;
                file_put_contents(storage_path('app/public/products/' . $filename), $image);
                $validated['image'] = 'products/' . $filename;
            }
        }

        $product->update($validated);
        return response()->json(
            [
                'message' => 'Product Updated Successfully',
                'data' => new ProductResource($product)
            ],
            200
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(
            [
                'message' => 'Product Deleted Successfully',

            ],
            200
        );

    }

}
