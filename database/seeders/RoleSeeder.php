<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, description: string}>
     */
    private const ROLES = [
        [
            'name' => 'Administrador',
            'description' => 'Acceso completo al sistema',
        ],
        [
            'name' => 'Curador',
            'description' => 'Persona que sube y gestiona obras de arte',
        ],
        [
            'name' => 'Visitante',
            'description' => 'Usuario con acceso de consulta y participación limitada',
        ],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::query()
            ->where('slug', 'admin')
            ->update([
                'slug' => 'administrador',
                'name' => 'Administrador',
                'description' => 'Acceso completo al sistema',
            ]);

        foreach (self::ROLES as $role) {
            Role::query()->updateOrCreate(
                ['slug' => Str::slug($role['name'])],
                [
                    'name' => $role['name'],
                    'description' => $role['description'],
                ]
            );
        }
    }
}
