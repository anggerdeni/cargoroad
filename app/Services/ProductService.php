<?php

namespace App\Services;

use Exception;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class ProductService
{
    protected ProductRepository $productRepository;
    protected UserRepository $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function index(string $search = null)
    {
        try {
            return $this->productRepository->index();
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve products:' . $e->getMessage(), 500);
        }
    }

    public function createProduct(array $data, $mediaFiles)
    {
        try {
            return $this->productRepository->create($data, $mediaFiles);
        } catch (Exception $e) {
            throw new Exception('Failed to create product:' . $e->getMessage(), 500);
        }
    }

    public function updateProduct(int $id, array $data)
    {
        try {
            $updater = $data['updated_by'];
            return $this->productRepository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception('Failed to update product:' . $e->getMessage(), 500);
        }
    }

    public function deleteProduct(int $id)
    {
        try {
            return $this->productRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception('Failed to delete product:' . $e->getMessage(), 500);
        }
    }
}
