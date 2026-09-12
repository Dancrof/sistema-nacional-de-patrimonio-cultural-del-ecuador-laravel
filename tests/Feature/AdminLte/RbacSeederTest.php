<?php

namespace Tests\Feature\AdminLte;

use Database\Seeders\AdminLteRbacSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_roles_are_seeded_for_the_mvp(): void
    {
        $this->seed(AdminLteRbacSeeder::class);

        $this->assertDatabaseHas('adminlte_roles', ['name' => 'admin']);
        $this->assertDatabaseHas('adminlte_roles', ['name' => 'administrador']);
        $this->assertDatabaseHas('adminlte_roles', ['name' => 'gestor']);
        $this->assertDatabaseHas('adminlte_roles', ['name' => 'moderador']);
        $this->assertDatabaseHas('adminlte_roles', ['name' => 'usuario']);
    }

    public function test_only_project_permissions_are_seeded(): void
    {
        $this->seed(AdminLteRbacSeeder::class);

        $expected = [
            'manage-artists',
            'manage-artworks',
            'manage-catalogs',
            'manage-geography',
            'manage-roles',
            'manage-users',
        ];

        $actual = \App\Models\Permission::query()->pluck('name')->sort()->values()->all();

        $this->assertSame($expected, $actual);
    }

    public function test_role_form_filters_out_demo_permissions_from_the_database(): void
    {
        $this->seed(AdminLteRbacSeeder::class);

        \App\Models\Permission::firstOrCreate(['name' => 'manage-mailbox'], ['label' => 'Manage Mailbox']);
        \App\Models\Permission::firstOrCreate(['name' => 'view-reports'], ['label' => 'View Reports']);

        $adminRole = \App\Models\Role::where('name', 'admin')->firstOrFail();
        $admin = \App\Models\User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->get(route('adminlte.roles.edit', $adminRole));

        $response->assertOk();
        $response->assertDontSee('Manage Mailbox');
        $response->assertDontSee('View Reports');
    }
}
