<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userHome()
    {
        $products = Product::where('status', 'active')->take(6)->get();
        return view('user.home', compact('products'));
    }

    public function adminHome()
    {
        return view('admin.home');
    }

    public function adminProfile()
    {
        return view('admin.profile');
    }

    public function managerHome()
    {
        return view('manager.home');
    }

    public function managerProfile()
    {
        return view('manager.profile');
    }

    public function index()
    {
        $categories = Category::all();
        $products = Product::all(); // Or fetch featured products

        return view('home', compact('categories', 'products'));
    }

    public function showCategoryProducts($id)
    {
        $categories = Category::with('children')->whereNull('deleted_at')->get();
        $selectedCategory = Category::with('children')->findOrFail($id);
        $products = Product::where('category_id', $id)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->get();

        return view('home', compact('categories', 'products', 'selectedCategory'));
    }

    public function showProductDetails($id){
        $product = Product::with('brand', 'category')->findOrFail($id);
        return view('product.details', compact('product'));
    }
}
