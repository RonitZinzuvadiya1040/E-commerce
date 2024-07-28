<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\Category\AddCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategoriesWithSearch($request);
        $brands = Brand::get();

        return view('category.index', compact('categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::get();

        return view('admin.category.create', compact('categories'));
    }

    public function store(AddCategoryRequest $request)
    {
        try {
            $this->categoryService->storeCategory($request);

            return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['image' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategory($id);
        $categories = $this->categoryService->getCategoriesExcluding($category->id);

        return view('admin.category.edit', compact('category', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($request, $id);

            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['image' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->destroyCategory($id);

            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Category deletion failed: ' . $e->getMessage());
        }
    }
}
