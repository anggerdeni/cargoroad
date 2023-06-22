<?php

namespace App\Repositories;

use Illuminate\Cache\CacheManager;

class BrandRepositoryCacheDecorator
{
    protected $brandRepository;
    protected $cache;

    public function __construct(BrandRepository $brandRepository, CacheManager $cache)
    {
        $this->brandRepository = $brandRepository;
        $this->cache = $cache;
    }

    public function index(int $perPage = 10, string $search = null)
    {
        $cacheKey = 'brands_' . $perPage . '_' . md5($search);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $brands = $this->brandRepository->index($perPage, $search);
        $this->cache->put($cacheKey, $brands, 3600); // Cache for 1 hour

        return $brands;
    }

    public function create(array $data)
    {
        $brand = $this->brandRepository->create($data);
        $this->cache->forget('brands'); // Invalidate the cache for brands

        return $brand;
    }

    public function update(int $id, array $data)
    {
        $brand = $this->brandRepository->update($id, $data);
        $this->cache->forget('brands'); // Invalidate the cache for brands

        return $brand;
    }

    public function delete(int $id)
    {
        $this->brandRepository->delete($id);
        $this->cache->forget('brands'); // Invalidate the cache for brands
    }
}
