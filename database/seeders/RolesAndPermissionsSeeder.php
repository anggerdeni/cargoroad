<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $viewerRole = Role::create(['name' => 'viewer']);

        // Create permissions
        $adminPermission = Permission::create(['name' => 'perform all task']);
        $createBrandPermission = Permission::create(['name' => 'create brand']);
        $editBrandPermission = Permission::create(['name' => 'edit brand']);
        $deleteBrandPermission = Permission::create(['name' => 'delete brand']);
        $viewBrandPermission = Permission::create(['name' => 'view brand']);
        $createCarPermission = Permission::create(['name' => 'create car']);
        $editCarPermission = Permission::create(['name' => 'edit car']);
        $deleteCarPermission = Permission::create(['name' => 'delete car']);
        $viewCarPermission = Permission::create(['name' => 'view car']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($adminPermission);
        $editorRole->givePermissionTo(
            $createCarPermission, $editCarPermission, $deleteCarPermission, $viewCarPermission,
            $viewBrandPermission,
        );
        $viewerRole->givePermissionTo($viewCarPermission);
    }
}
