<?php

namespace App\Services;

use Exception;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;

class ProductService
{
    protected ProductRepository $productRepository;
    protected UserRepository $userRepository;

    public function getMaxMediaPerProduct(): int
    {
        return 10;
    }

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
            throw new Exception('Failed to retrieve products: ' . $e->getMessage());
        }
    }

    public function createProduct(array $data, $mediaFiles)
    {
        try {
            return $this->productRepository->create($data, $mediaFiles);
        } catch (Exception $e) {
            throw new Exception('Failed to create product: ' . $e->getMessage());
        }
    }

    public function updateProduct(int $id, array $data)
    {
        try {
            if (!$this->allowEditAction($id, $data['updated_by'])) throw new Exception('action not allowed');

            return $this->productRepository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception('Failed to update product: ' . $e->getMessage());
        }
    }

    public function deleteProduct(int $id, int $userID)
    {
        try {
            if (!$this->allowEditAction($id, $userID)) throw new Exception('action not allowed');

            return $this->productRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception('Failed to delete product: ' . $e->getMessage());
        }
    }

    public function addMedia(int $id, $media, int $userID)
    {
        try {
            if (!$this->allowEditAction($id, $userID)) throw new Exception('action not allowed');
            if ($this->productRepository->getTotalMediaByProductID($id) >= $this->getMaxMediaPerProduct()) {
                throw new Exception('product has reached maximum media allowed');
            }

            return $this->productRepository->addMedia($id, $media);
        } catch (Exception $e) {
            throw new Exception('Failed to add media: ' . $e->getMessage());
        }
    }

    public function removeMedia(int $id, int $mediaID, int $userID)
    {
        try {
            if (!$this->allowEditAction($id, $userID)) throw new Exception('action not allowed');

            return $this->productRepository->removeMedia($id, $mediaID);
        } catch (Exception $e) {
            throw new Exception('Failed to add media: ' . $e->getMessage());
        }
    }

    private function allowEditAction(int $id, $updater): bool
    {
        $product = $this->productRepository->getByID($id);
        $creator = $product->created_by;

        if ($creator === $updater) return true;
        if($this->userRepository->canPerformAllTask($updater)) return true;
        return false;

    }
}
