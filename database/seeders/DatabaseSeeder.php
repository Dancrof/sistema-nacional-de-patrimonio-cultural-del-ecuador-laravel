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
            CategorySeeder::class,
            ArtworkTypeSeeder::class,
            ConservationStatusSeeder::class,
            AdminLteRbacSeeder::class,
        ]);

        $user = User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $user->assignRole('admin');
    }
}
