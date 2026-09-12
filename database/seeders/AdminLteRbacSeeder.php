<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminLteRbacSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view-dashboard' => 'View Dashboard',
            'manage-users' => 'Manage Users',
            'manage-roles' => 'Manage Roles',
            'manage-artists' => 'Manage Artists',
            'manage-artworks' => 'Manage Artworks',
            'moderate-comments' => 'Moderate Comments',
            'manage-catalogs' => 'Manage Catalogs',
            'manage-geography' => 'Manage Geography',
            'view-public-portal' => 'View Public Portal',
        ];

        foreach ($permissions as $name => $label) {
            Permission::firstOrCreate(['name' => $name], ['label' => $label]);
        }

        $roles = [
            'admin' => [
                'label' => 'Administrador',
                'permissions' => array_keys($permissions),
            ],
            'administrador' => [
                'label' => 'Administrador',
                'permissions' => array_keys($permissions),
            ],
            'gestor' => [
                'label' => 'Gestor',
                'permissions' => [
                    'view-dashboard',
                    'manage-artists',
                    'manage-artworks',
                    'manage-catalogs',
                    'manage-geography',
                    'view-public-portal',
                ],
            ],
            'moderador' => [
                'label' => 'Moderador',
                'permissions' => [
                    'view-dashboard',
                    'moderate-comments',
                    'view-public-portal',
                ],
            ],
            'usuario' => [
                'label' => 'Usuario',
                'permissions' => [
                    'view-dashboard',
                    'view-public-portal',
                ],
            ],
        ];

        foreach ($roles as $name => $definition) {
            $role = Role::firstOrCreate(['name' => $name], ['label' => $definition['label']]);

            /** @var array{label: string, permissions: array<int, string>} $definition */
            $permissionIds = Permission::whereIn('name', $definition['permissions'])->pluck('id')->toArray();

            $role->permissions()->syncWithoutDetaching($permissionIds);
        }

        $user = User::first();

        if ($user !== null) {
            $admin = Role::whereIn('name', ['admin', 'administrador'])->first();

            if ($admin !== null) {
                $user->roles()->syncWithoutDetaching([$admin->id]);
            }
        }
    }
}
