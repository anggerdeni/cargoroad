<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createEditor(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = $this->userModel->create($data);
            $editorRole = Role::findByName('editor');
            $user->assignRole($editorRole);
            return $user;
        });
    }
    public function update(int $id, array $data)
    {
        $user = $this->userModel->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->userModel->findOrFail($id);
        $user->delete();
    }

    public function canPerformAllTask(int $id): bool
    {
        $user = User::find($id);
        $permissionNames = $user->getPermissionNames();

        foreach($permissionNames as $permissionName) {
            if($permissionName === 'perform all task') return true;
        }

        return false;
    }
}
