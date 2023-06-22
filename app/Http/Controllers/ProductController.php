<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $products = $this->productService->index($request->search);
            return response()->json([
                'success' => true,
                'message' => 'OK',
                'data' => $products,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'brand_id' => 'required|exists:brands,id',
                'media' => 'array|max:10',
                'media.*' => 'image|max:2048',
            ]);
            $data['created_by'] = $request->user()->id;
            $product = $this->productService->createProduct($data, $request->file('media'));

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with('brand', 'productMedia', 'createdBy')->find($id);

            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'OK',
                    'data' => $product,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'name' => 'string|max:255',
                'description' => 'string|max:200',
                'brand_id' => 'exists:brands,id',
            ]);
            $data['updated_by'] = $request->user()->id;
            $product = $this->productService->updateProduct($id, $data);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $product = $this->productService->deleteProduct($id, $request->user()->id);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
                'data' => $product,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Add media
     */
    public function addMedia(Request $request, string $id)
    {
        try {
            $data = $request->validate([
                'media' => 'required|image|max:2048',
            ]);
            $media = $this->productService->addMedia($id, $request->file('media'), $request->user()->id);

            return response()->json([
                'success' => true,
                'message' => 'Media added successfully',
                'data' => $media,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    /**
     * Remove media
     */
    public function removeMedia(Request $request, string $id, string $media_id)
    {
        try {
            $media = $this->productService->removeMedia($id, $media_id, $request->user()->id);

            return response()->json([
                'success' => true,
                'message' => 'Media removed successfully',
                'data' => $media,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }
}
