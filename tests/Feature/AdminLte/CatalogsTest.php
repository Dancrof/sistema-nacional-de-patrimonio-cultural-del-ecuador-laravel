<?php

namespace Tests\Feature\AdminLte;

use App\Models\Category;
use App\Models\ConservationStatus;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\ArtworkType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_manage_catalog_entries(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-catalogs'], ['label' => 'Manage Catalogs']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Catalog',
            'name' => 'Admin Catalog',
            'username' => 'admin_catalog',
            'email' => 'admin.catalog@example.com',
        ]);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->post(route('adminlte.categories.store'), [
                'name' => 'Pinturas',
                'description' => 'Obras pictóricas',
            ])
            ->assertRedirect(route('adminlte.categories.index'));

        $this->assertDatabaseHas('categories', ['name' => 'Pinturas', 'slug' => 'pinturas']);

        $this->actingAs($admin)
            ->post(route('adminlte.artwork-types.store'), [
                'name' => 'Óleo sobre lienzo',
                'description' => 'Pintura con óleo',
            ])
            ->assertRedirect(route('adminlte.artwork-types.index'));

        $this->assertDatabaseHas('artwork_types', ['name' => 'Óleo sobre lienzo', 'slug' => 'oleo-sobre-lienzo']);

        $this->actingAs($admin)
            ->post(route('adminlte.conservation-statuses.store'), [
                'name' => 'Excelente',
                'description' => 'Estado óptimo',
            ])
            ->assertRedirect(route('adminlte.conservation-statuses.index'));

        $this->assertDatabaseHas('conservation_statuses', ['name' => 'Excelente', 'slug' => 'excelente']);
	}
}
