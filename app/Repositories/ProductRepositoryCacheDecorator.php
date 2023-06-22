<?php

namespace App\Repositories;

use Illuminate\Cache\CacheManager;

class ProductRepositoryCacheDecorator
{
    protected $productRepository;
    protected $cache;

    public function __construct(ProductRepository $productRepository, CacheManager $cache)
    {
        $this->productRepository = $productRepository;
        $this->cache = $cache;
    }

    public function index(int $perPage = 10, string $search = null)
    {
        $cacheKey = 'products_' . $perPage . '_' . md5($search);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $products = $this->productRepository->index($perPage, $search);
        $this->cache->put($cacheKey, $products, 3600); // Cache for 1 hour

        return $products;
    }

    public function getByID(int $id)
    {
        $cacheKey = 'product_' . $id;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $product = $this->productRepository->getByID($id);
        $this->cache->put($cacheKey, $product, 3600); // Cache for 1 hour

        return $product;
    }

    public function getTotalMediaByProductID(int $id): int
    {
        $cacheKey = 'product_media_count_' . $id;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $mediaCount = $this->productRepository->getTotalMediaByProductID($id);
        $this->cache->put($cacheKey, $mediaCount, 3600); // Cache for 1 hour

        return $mediaCount;
    }

    public function create(array $data, $mediaFiles)
    {
        $product = $this->productRepository->create($data, $mediaFiles);
        $this->cache->forget('products'); // Invalidate the cache for products

        return $product;
    }

    public function update(int $id, array $data)
    {
        $product = $this->productRepository->update($id, $data);
        $this->cache->forget('products'); // Invalidate the cache for products
        $this->cache->forget('product_' . $id); // Invalidate the cache for the specific product

        return $product;
    }

    public function delete(int $id)
    {
        $this->productRepository->delete($id);
        $this->cache->forget('products'); // Invalidate the cache for products
        $this->cache->forget('product_' . $id); // Invalidate the cache for the specific product
    }

    public function addMedia(int $id, $file)
    {
        $media = $this->productRepository->addMedia($id, $file);
        $this->cache->forget('product_media_count_' . $id); // Invalidate the cache for the product's media count

        return $media;
    }

    public function removeMedia(int $productID, $mediaID)
    {
        $this->productRepository->removeMedia($productID, $mediaID);
        $this->cache->forget('product_media_count_' . $productID); // Invalidate the cache for the product's media count
    }
}
