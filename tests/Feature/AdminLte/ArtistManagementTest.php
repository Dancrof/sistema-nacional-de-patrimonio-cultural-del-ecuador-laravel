<?php

namespace Tests\Feature\AdminLte;

use App\Models\Artist;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_artist(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-artists'], ['label' => 'Manage Artists']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Artist',
            'name' => 'Admin Artist',
            'username' => 'admin_artist',
            'email' => 'admin.artist@example.com',
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->post(route('adminlte.artists.store'), [
                'first_name' => 'Oswaldo',
                'last_name' => 'Guayasamín',
                'birth_date' => '1919-07-06',
                'birth_place' => 'Quito',
                'nationality' => 'Ecuatoriana',
                'biography' => 'Artista ecuatoriano reconocido internacionalmente.',
                'website' => 'https://example.com',
            ]);

        $response->assertRedirect(route('adminlte.artists.index'));
        $this->assertDatabaseHas('artists', [
            'first_name' => 'Oswaldo',
            'last_name' => 'Guayasamín',
            'full_name' => 'Oswaldo Guayasamín',
            'slug' => 'oswaldo-guayasamin',
        ]);
    }
}
