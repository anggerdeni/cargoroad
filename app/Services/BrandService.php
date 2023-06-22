<?php

namespace App\Services;

use App\DTO\BrandDTO;
use App\Repositories\BrandRepository;

class BrandService
{
    protected BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(string $search = null)
    {
        // probably we can add some fancy input sanitazion here?
        return $this->brandRepository->index();
    }

    public function createBrand(array $data)
    {
        return $this->brandRepository->create($data)->toArray();
    }

    public function updateBrand(int $id, array $data)
    {
        return $this->brandRepository->update($id, $data);
    }

    public function deleteBrand(int $id)
    {
        return $this->brandRepository->delete($id);
    }
}
