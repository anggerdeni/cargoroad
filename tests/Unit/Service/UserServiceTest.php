<?php
namespace Tests\Unit\Service;

use App\Repositories\UserRepository;
use App\Services\UserService;
use PHPUnit\Framework\TestCase;
use Exception;

class UserServiceTest extends TestCase
{
    protected $userRepository;
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock instance of UserRepository
        $this->userRepository = $this->createMock(UserRepository::class);

        // Create an instance of UserService with the mock UserRepository
        $this->userService = new UserService($this->userRepository);
    }

    public function testRegisterNewEditor_Success()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        // Set up the expected method call and return value on the mock UserRepository
        $this->userRepository->expects($this->once())
            ->method('createEditor')
            ->with($userData)
            ->willReturn(['id' => 1, 'name' => 'John Doe', 'email' => 'johndoe@example.com']);

        // Call the registerNewEditor method
        $result = $this->userService->registerNewEditor($userData);

        // Assert that the result matches the expected return value
        $this->assertEquals(['id' => 1, 'name' => 'John Doe', 'email' => 'johndoe@example.com'], $result);
    }

    public function testRegisterNewEditor_Failure()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        // Set up the expected method call on the mock UserRepository to throw an exception
        $this->userRepository->expects($this->once())
            ->method('createEditor')
            ->with($userData)
            ->willThrowException(new Exception('Failed to create editor.'));

        // Call the registerNewEditor method and expect an exception to be thrown
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Failed to register user: Failed to create editor.');

        $this->userService->registerNewEditor($userData);
    }
}

