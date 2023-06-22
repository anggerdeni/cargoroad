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

    public function getByID(int $id)
    {
        return $this->productModel->findOrFail($id);
    }

    public function getTotalMediaByProductID(int $id): int
    {
        return $this->productModel->find($id)->productMedia()->count();
    }

    public function create(array $data, $mediaFiles)
    {
        return DB::transaction(function () use ($data, $mediaFiles) {
            $product = $this->productModel->create($data);
            if(!empty($mediaFiles)) {
                foreach ($mediaFiles as $file) {
                    $filename = uniqid('media_') . '.' . $file->getClientOriginalExtension();
                    $path = Storage::disk('public')->putFileAs('product_media', $file, $filename);

                    $product->productMedia()->create([
                        'file_name' => $filename,
                        'file_path' => $path,
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
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

    public function addMedia(int $id, $file)
    {
        $product = $this->productModel->findOrFail($id);

        $filename = uniqid('media_') . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('product_media', $file, $filename);

        return $product->productMedia()->create([
            'file_name' => $filename,
            'file_path' => $path,
            'mime_type' => $file->getMimeType(),
        ]);
    }

    public function removeMedia(int $productID, $mediaID)
    {
        $product = $this->productModel->findOrFail($productID);
        return $product->productMedia()->where('id', $mediaID)->firstOrFail()->delete();
    }
}
