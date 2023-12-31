<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{
    protected $brandModel;

    public function __construct(Brand $brandModel)
    {
        $this->brandModel = $brandModel;
    }

    public function index(int $perPage = 10, string $search = null)
    {
        $query = $this->brandModel->query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->brandModel->create($data);
    }

    public function update(int $id, array $data)
    {
        $brand = $this->brandModel->findOrFail($id);
        $brand->update($data);
        return $brand;
    }

    public function delete(int $id)
    {
        $brand = $this->brandModel->findOrFail($id);
        $brand->delete();
    }
}
