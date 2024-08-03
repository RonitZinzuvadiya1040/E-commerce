<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService
{
    public function getAllBrandsWithSearch(Request $request)
    {
        $search = $request->input('search');
        $query = Brand::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('slug', 'like', "%{$search}%");
        }

        return $query->whereNull('deleted_at')->paginate(10);
    }

    public function storeBrand($request)
    {
        $imageName = $this->handleImageUpload($request);

        try {
            Brand::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imageName,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Brand creation failed: ' . $e->getMessage());
        }
    }

    public function updateBrand($request, $id)
    {
        $brand = Brand::findOrFail($id);
        $imageName = $this->handleImageUpload($request, $brand);

        try {
            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imageName ?? $brand->image,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Brand update failed: ' . $e->getMessage());
        }
    }

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image) {
            Storage::delete('public/brands/' . $brand->image);
        }

        try {
            $brand->delete();
        } catch (\Exception $e) {
            throw new \Exception('Brand deletion failed: ' . $e->getMessage());
        }
    }

    private function handleImageUpload($request, $existingBrand = null)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if (!$image->isValid()) {
                throw new \Exception('Invalid image file.');
            }

            $uniqueCode = uniqid();
            $imageName = Str::slug($request->name) . '-' . $uniqueCode . '.' . $image->getClientOriginalExtension();

            try {
                Storage::put('public/brands/' . $imageName, file_get_contents($image->getRealPath()));

                if ($existingBrand && $existingBrand->image) {
                    Storage::delete('public/brands/' . $existingBrand->image);
                }
            } catch (\Exception $e) {
                throw new \Exception('Image storage failed: ' . $e->getMessage());
            }
        }

        return $imageName;
    }
}
