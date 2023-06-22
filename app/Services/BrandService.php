<?php

namespace App\Services;

use Exception;
use App\Repositories\BrandRepositoryCacheDecorator;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepositoryCacheDecorator $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(string $search = null)
    {
        try {
            return $this->brandRepository->index(search: $search);
        } catch (Exception $e) {
            throw new Exception('Failed to retrieve brands: ' . $e->getMessage());
        }
    }

    public function createBrand(array $data)
    {
        try {
            return $this->brandRepository->create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create brand: ' . $e->getMessage());
        }
    }

    public function updateBrand(int $id, array $data)
    {
        try {
            return $this->brandRepository->update($id, $data);
        } catch (Exception $e) {
            throw new Exception('Failed to update brand: ' . $e->getMessage());
        }
    }

    public function deleteBrand(int $id)
    {
        try {
            return $this->brandRepository->delete($id);
        } catch (Exception $e) {
            throw new Exception('Failed to delete brand: ' . $e->getMessage());
        }
    }
}
