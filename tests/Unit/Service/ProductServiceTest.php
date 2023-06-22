<?php
namespace Tests\Unit\Service;

use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Exception;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    protected ProductService $productService;
    protected ProductRepository $productRepository;
    protected UserRepository $userRepository;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->productService = new ProductService($this->productRepository, $this->userRepository);
    }

    public function testGetMaxMediaPerProduct()
    {
        $maxMedia = $this->productService->getMaxMediaPerProduct();

        $this->assertEquals(10, $maxMedia);
    }

    public function testIndex()
    {
        $this->productRepository->expects($this->once())
            ->method('index')
            ->with(10, null)
            ->willReturn([]);

        $products = $this->productService->index();

        $this->assertEquals([], $products);
    }

    public function testCreateProduct()
    {
        $data = ['name' => 'Product 1', 'price' => 10];
        $mediaFiles = [];

        $this->productRepository->expects($this->once())
            ->method('create')
            ->with($data, $mediaFiles)
            ->willReturn(['id' => 1, 'name' => 'Product 1', 'price' => 10]);

        $product = $this->productService->createProduct($data, $mediaFiles);

        $this->assertEquals(['id' => 1, 'name' => 'Product 1', 'price' => 10], $product);
    }

    public function testUpdateProductWithAllowedAction()
    {
        $id = 1;
        $userID = 2;
        $data = ['name' => 'Updated Product', 'price' => 20, 'updated_by' => $userID];

        $product = (object)['id' => $id, 'created_by' => $userID];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->productRepository->expects($this->once())
            ->method('update')
            ->with($id, $data);

        $this->productService->updateProduct($id, $data);
    }

    public function testUpdateProductWithAllowedActionFromAdmin()
    {
        $id = 1;
        $userID = 2;
        $data = ['name' => 'Updated Product', 'price' => 20, 'updated_by' => $userID];

        $product = (object)['id' => $id, 'created_by' => 1];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(true);

        $this->productRepository->expects($this->once())
            ->method('update')
            ->with($id, $data);

        $this->productService->updateProduct($id, $data);
    }

    public function testUpdateProductWithNotAllowedAction()
    {
        $id = 1;
        $userID = 2;
        $data = ['name' => 'Updated Product', 'price' => 20, 'updated_by' => $userID];

        $product = (object)['id' => $id, 'created_by' => 3];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to update product: action not allowed');

        $this->productService->updateProduct($id, $data);
    }

    public function testDeleteProductWithAllowedAction()
    {
        $id = 1;
        $userID = 2;

        $product = (object)['id' => $id, 'created_by' => $userID];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->productRepository->expects($this->once())
            ->method('delete')
            ->with($id);

        $this->productService->deleteProduct($id, $userID);
    }

    public function testDeleteProductWithAllowedActionFromAdmin()
    {
        $id = 1;
        $userID = 2;

        $product = (object)['id' => $id, 'created_by' => 1];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(true);

        $this->productRepository->expects($this->once())
            ->method('delete')
            ->with($id);

        $this->productService->deleteProduct($id, $userID);
    }

    public function testDeleteProductWithNotAllowedAction()
    {
        $id = 1;
        $userID = 2;

        $product = (object)['id' => $id, 'created_by' => 3];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($id)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to delete product: action not allowed');

        $this->productService->deleteProduct($id, $userID);
    }

    public function testAddMediaWithAllowedAction()
    {
        $productID = 1;
        $media = 'test_media';
        $userID = 3;

        $product = (object)['id' => $productID, 'created_by' => $userID];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($productID)
            ->willReturn($product);

        $this->productRepository->expects($this->once())
            ->method('getTotalMediaByProductID')
            ->with($productID)
            ->willReturn(5);

        $this->productRepository->expects($this->once())
            ->method('addMedia')
            ->with($productID, $media);

        $this->productService->addMedia($productID, $media, $userID);
    }

    public function testAddMediaWithAllowedActionFromAdmin()
    {
        $productID = 1;
        $media = 'test_media';
        $userID = 3;

        $product = (object)['id' => $productID, 'created_by' => 1];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($productID)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(true);

        $this->productRepository->expects($this->once())
            ->method('getTotalMediaByProductID')
            ->with($productID)
            ->willReturn(5);

        $this->productRepository->expects($this->once())
            ->method('addMedia')
            ->with($productID, $media);

        $this->productService->addMedia($productID, $media, $userID);
    }

    public function testAddMediaWithNotAllowedAction()
    {
        $productID = 1;
        $media = 'test_media';
        $userID = 3;

        $product = (object)['id' => $productID, 'created_by' => 1];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($productID)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('action not allowed');

        $this->productService->addMedia($productID, $media, $userID);
    }

    public function testRemoveMediaWithAllowedAction()
    {
        $productID = 1;
        $mediaID = 2;
        $userID = 1;

        $product = (object)['id' => $productID, 'created_by' => 1];

        $this->productRepository->expects($this->once())
                                ->method('getByID')
                                ->with($productID)
                                ->willReturn($product);

        $this->productRepository->expects($this->once())
                                ->method('removeMedia')
                                ->with($productID, $mediaID);

        $this->productService->removeMedia($productID, $mediaID, $userID);
    }

    public function testRemoveMediaWithAllowedActionFromAdmin()
    {
        $productID = 1;
        $mediaID = 2;
        $userID = 3;

        $product = (object)['id' => $productID, 'created_by' => 1];

        $this->productRepository->expects($this->once())
                                ->method('getByID')
                                ->with($productID)
                                ->willReturn($product);

        $this->userRepository->expects($this->once())
                             ->method('canPerformAllTask')
                             ->with($userID)
                             ->willReturn(true);

        $this->productRepository->expects($this->once())
                                ->method('removeMedia')
                                ->with($productID, $mediaID);

        $this->productService->removeMedia($productID, $mediaID, $userID);
    }

        public function testRemoveMediaWithNotAllowedAction()
    {
        $productID = 1;
        $mediaID = 2;
        $userID = 3;

        $product = (object)['id' => $productID, 'created_by' => 1];

        $this->productRepository->expects($this->once())
            ->method('getByID')
            ->with($productID)
            ->willReturn($product);

        $this->userRepository->expects($this->once())
            ->method('canPerformAllTask')
            ->with($userID)
            ->willReturn(false);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('action not allowed');

        $this->productService->removeMedia($productID, $mediaID, $userID);
    }

}

