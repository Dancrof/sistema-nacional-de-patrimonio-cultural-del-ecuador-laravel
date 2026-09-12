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
            'manage-users' => 'Manage Users',
            'manage-roles' => 'Manage Roles',
            'manage-geography' => 'Manage Geography',
            'manage-catalogs' => 'Manage Catalogs',
            'manage-artists' => 'Manage Artists',
            'manage-artworks' => 'Manage Artworks',
        ];

        foreach ($permissions as $name => $label) {
            Permission::firstOrCreate(['name' => $name], ['label' => $label]);
        }

        Permission::whereNotIn('name', array_keys($permissions))->delete();

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
                    'manage-artists',
                    'manage-artworks',
                    'manage-catalogs',
                    'manage-geography',
                ],
            ],
            'moderador' => [
                'label' => 'Moderador',
                'permissions' => [
                    'manage-artworks',
                ],
            ],
            'usuario' => [
                'label' => 'Usuario',
                'permissions' => [],
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
