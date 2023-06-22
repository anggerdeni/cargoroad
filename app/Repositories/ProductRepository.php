<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductRepository
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function index(int $perPage = 10, string $search = null)
    {
        $query = $this->productModel->query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data, $mediaFiles)
    {
        return DB::transaction(function () use ($data, $mediaFiles) {
            $product = $this->productModel->create($data);
            foreach ($mediaFiles as $file) {
                $filename = uniqid('media_') . '.' . $file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('product_media', $file, $filename);

                $product->productMedia()->create([
                    'file_name' => $filename,
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                ]);
            }
            return $product;
        });
    }

    public function update(int $id, array $data)
    {
        $product = $this->productModel->findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->productModel->findOrFail($id);
        $product->delete();
    }

    public function addMedia(int $id, $media)
    {
    }

    public function removeMedia(int $productID, $mediaID)
    {
    }
}
