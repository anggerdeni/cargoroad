<?php
namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Services\BrandService;
use App\Repositories\BrandRepositoryCacheDecorator;

class BrandServiceTest extends TestCase
{
    protected BrandService $brandService;
    protected BrandRepositoryCacheDecorator $brandRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of the BrandRepositoryCacheDecorator
        $this->brandRepository = $this->createMock(BrandRepositoryCacheDecorator::class);

        // Create an instance of the BrandService, injecting the mock repository
        $this->brandService = new BrandService($this->brandRepository);
    }

    public function testIndexReturnsBrands()
    {
        // Arrange
        $search = 'example';

        // Define the expected result
        $expectedResult = ['brand1', 'brand2', 'brand3'];

        // Set up the mock repository's behavior
        $this->brandRepository
            ->expects($this->once())
            ->method('index')
            ->with(per_page: 10, search: $search)
            ->willReturn($expectedResult);

        // Act
        $result = $this->brandService->index($search);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }

    public function testCreateBrand()
    {
        // Arrange
        $data = ['name' => 'Example Brand'];

        // Set up the mock repository's behavior
        $this->brandRepository
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($data);

        // Act
        $result = $this->brandService->createBrand($data);

        // Assert
        $this->assertEquals($data, $result);
    }

    public function testUpdateBrand()
    {
        // Arrange
        $id = 1;
        $data = ['name' => 'Updated Brand'];

        // Set up the mock repository's behavior
        $this->brandRepository
            ->expects($this->once())
            ->method('update')
            ->with($id, $data)
            ->willReturn(true);

        // Act
        $result = $this->brandService->updateBrand($id, $data);

        // Assert
        $this->assertTrue($result);
    }

    public function testDeleteBrand()
    {
        // Arrange
        $id = 1;

        // Set up the mock repository's behavior
        $this->brandRepository
            ->expects($this->once())
            ->method('delete')
            ->with($id)
            ->willReturn(true);

        // Act
        $result = $this->brandService->deleteBrand($id);

        // Assert
        $this->assertTrue($result);
    }
}

