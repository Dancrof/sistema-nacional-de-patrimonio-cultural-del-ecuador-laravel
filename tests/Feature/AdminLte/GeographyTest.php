<?php

namespace Tests\Feature\AdminLte;

use App\Models\Permission;
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

        $province = \App\Models\Province::where('slug', 'pichincha')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('adminlte.cantons.store'), [
                'province_id' => $province->id,
                'name' => 'Quito',
            ])
            ->assertRedirect(route('adminlte.cantons.index'));

        $this->assertDatabaseHas('cantons', ['province_id' => $province->id, 'name' => 'Quito']);
    }
}
