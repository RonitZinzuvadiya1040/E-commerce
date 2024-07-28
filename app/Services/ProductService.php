<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with(['category', 'brand'])->get();
    }

    public function storeProduct(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/product', $newImageName);
        } else {
            throw new \Exception('Image file is required');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->stock = $request->stock;
        $product->image = $newImageName;
        $product->status = $request->status;

        $product->save();
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('storage/product/' . $product->image))) {
                unlink(public_path('storage/product/' . $product->image));
            }

            $image = $request->file('image');
            $newImageName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/product', $newImageName);
            $product->image = $newImageName;
        }

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->sku = $request->sku;
        $product->stock = $request->stock;
        $product->status = $request->status;

        $product->save();
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete('public/product/' . $product->image);
        }

        $product->delete();
    }

    public function getProduct($id)
    {
        return Product::findOrFail($id);
    }
}
