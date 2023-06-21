<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function create(array $data)
    {
        return $this->productModel->create($data);
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

    // Add any other methods as needed
}
