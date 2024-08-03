<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BrandService;
use App\Http\Requests\Brand\AddBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index(Request $request)
    {
        $brands = $this->brandService->getAllBrandsWithSearch($request);
        return view('brand.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(AddBrandRequest $request)
    {
        try {
            $this->brandService->storeBrand($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.brand.index')->with('success', 'Brand added successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('admin.brand.index')->with('error', 'Brand not found.');
        }

        return view('admin.brand.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, $id)
    {
        try {
            $this->brandService->updateBrand($request, $id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.brand.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $this->brandService->deleteBrand($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.brand.index')->with('success', 'Brand deleted successfully!');
    }
}
