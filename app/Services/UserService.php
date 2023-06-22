<?php

namespace App\Services;

use Exception;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerNewEditor(array $data)
    {
        try {
            return $this->userRepository->createEditor($data);
        } catch (Exception $e) {
            throw new Exception('Failed to register user: ' . $e->getMessage());
        }
    }
}
