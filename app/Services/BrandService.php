<?php

namespace App\Services;

use App\Repositories\BrandRepository;

class BrandService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function createBrand(array $data)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->brandRepository->create($data);
    }

    public function updateBrand(int $id, array $data)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->brandRepository->update($id, $data);
    }

    public function deleteBrand(int $id)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->brandRepository->delete($id);
    }
}
