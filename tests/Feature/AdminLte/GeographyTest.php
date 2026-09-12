<?php

namespace Tests\Feature\AdminLte;

use App\Models\Canton;
use App\Models\Parish;
use App\Models\Permission;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeographyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_province_and_canton(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-geography'], ['label' => 'Manage Geography']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Geo',
            'name' => 'Admin Geo',
            'username' => 'admin_geo',
            'email' => 'admin.geo@example.com',
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->post(route('adminlte.provinces.store'), [
                'name' => 'Pichincha',
                'region' => 'Sierra',
                'description' => 'Provincial test',
            ]);

        $response->assertRedirect(route('adminlte.provinces.index'));
        $this->assertDatabaseHas('provinces', ['name' => 'Pichincha', 'slug' => 'pichincha']);

        $province = Province::where('slug', 'pichincha')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('adminlte.cantons.store'), [
                'province_id' => $province->id,
                'name' => 'Quito',
            ])
            ->assertRedirect(route('adminlte.cantons.index'));

        $this->assertDatabaseHas('cantons', ['province_id' => $province->id, 'name' => 'Quito']);
    }

    public function test_canton_and_parish_endpoints_return_only_filtered_records(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-geography'], ['label' => 'Manage Geography']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Geo',
            'name' => 'Admin Geo',
            'username' => 'admin_geo_filter',
            'email' => 'admin.geo.filter@example.com',
        ]);
        $admin->assignRole('admin');

        $provinceA = Province::create(['name' => 'Pichincha', 'slug' => 'pichincha', 'region' => 'Sierra']);
        $provinceB = Province::create(['name' => 'Guayas', 'slug' => 'guayas', 'region' => 'Costa']);

        $cantonA = Canton::create(['province_id' => $provinceA->id, 'name' => 'Quito', 'slug' => 'quito']);
        $cantonB = Canton::create(['province_id' => $provinceA->id, 'name' => 'Pedro Moncayo', 'slug' => 'pedro-moncayo']);
        $cantonC = Canton::create(['province_id' => $provinceB->id, 'name' => 'Guayaquil', 'slug' => 'guayaquil']);

        Parish::create(['canton_id' => $cantonA->id, 'name' => 'Centro Histórico', 'slug' => 'centro-historico']);
        Parish::create(['canton_id' => $cantonA->id, 'name' => 'La Floresta', 'slug' => 'la-floresta']);
        Parish::create(['canton_id' => $cantonC->id, 'name' => 'Urdesa', 'slug' => 'urdesa']);

        $this->actingAs($admin)
            ->getJson(route('adminlte.cantons.index', ['province_id' => $provinceA->id]))
            ->assertOk()
            ->assertJsonPath('0.name', 'Pedro Moncayo')
            ->assertJsonMissing(['name' => 'Guayaquil']);

        $this->actingAs($admin)
            ->getJson(route('adminlte.parishes.index', ['canton_id' => $cantonA->id]))
            ->assertOk()
            ->assertJsonPath('0.name', 'Centro Histórico')
            ->assertJsonMissing(['name' => 'Urdesa']);
    }
}
