<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Product\AddProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Brand;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAllProductsWithSearch($request);
        return view('product.index', compact('products'));
    }

    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        return view('product.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(AddProductRequest $request)
    {
        try {
            $this->productService->storeProduct($request);
            return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['image' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = $this->productService->getProduct($id);
        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();
        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $this->productService->updateProduct($request, $id);
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['image' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->destroyProduct($id);
            return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Product deletion failed: ' . $e->getMessage());
        }
    }
}
