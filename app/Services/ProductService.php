<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->productRepository->create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->productRepository->delete($id);
    }
}
