<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;

class BrandController extends Controller
{
    protected BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = $this->brandService->index();
        return response()->json([
            'success' => true,
            'message' => 'ok',
            'data' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'address' => 'required|string|max:500',
        ]);
        $data['created_by'] = $request->user()->id;
        $brand = $this->brandService->createBrand($data);

        return response()->json([
            'success' => true,
            'message' => 'Brand created successfully',
            'data' => $brand,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'ok',
            'data' => Brand::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'string|max:255|unique:brands',
            'address' => 'string|max:500',
        ]);
        $data['updated_by'] = $request->user()->id;
        $brand = $this->brandService->updateBrand($id, $data);

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully',
            'data' => $brand,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = $this->brandService->deleteBrand($id);

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully',
            'data' => $brand,
        ], 200);
    }
}
