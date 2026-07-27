<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EcuadorLocationSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
        ]);

        $adminRole = Role::query()->where('slug', 'administrador')->firstOrFail();

        User::factory()->create([
            'role_id' => $adminRole->id,
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
    }
}
