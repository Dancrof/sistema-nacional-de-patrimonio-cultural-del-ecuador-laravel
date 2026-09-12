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
}
