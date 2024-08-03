<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function getAllCategoriesWithSearch(Request $request)
    {
        $search = $request->input('search');
        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")->orWhere('slug', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%");
        }

        return $query->with('parentCategory')->whereNull('deleted_at')->paginate(10);
    }

    public function storeCategory(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newImageName = strtolower(str_replace(' ', '_', $request->name)) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/categories', $newImageName);
        } else {
            throw new \Exception('Image file is required');
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id ? $request->parent_id : null;
        $category->image = $newImageName;

        $category->save();
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path('storage/categories/' . $category->image))) {
                unlink(public_path('storage/categories/' . $category->image));
            }

            $image = $request->file('image');
            $imageName = strtolower(str_replace(' ', '_', $category->name)) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('categories', $imageName, 'public');
            $category->image = $imageName;
        }

        $category->parent_id = $request->input('parent_id');
        $category->save();
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            Storage::delete('public/categories/' . $category->image);
        }

        $category->delete();
    }

    public function getCategory($id)
    {
        return Category::findOrFail($id);
    }

    public function getCategoriesExcluding($id)
    {
        return Category::where('id', '!=', $id)->get();
    }
}
