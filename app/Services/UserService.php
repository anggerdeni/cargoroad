<?php

namespace App\Services;

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
        return $this->userRepository->createEditor($data);
    }

    public function updateUser(int $id, array $data)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id)
    {
        // Add any business logic here, such as validation or data manipulation
        return $this->userRepository->delete($id);
    }
}
