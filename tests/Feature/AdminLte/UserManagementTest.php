<?php

namespace Tests\Feature\AdminLte;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user_with_profile_fields(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-users'], ['label' => 'Manage Users']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'name' => 'Admin User',
            'username' => 'admin_user',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)
            ->from(route('adminlte.users.index'))
            ->post(route('adminlte.users.store'), [
                'first_name' => 'Carlos',
                'last_name' => 'Mendoza',
                'username' => 'carlosmendoza',
                'email' => 'carlos@example.com',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
                'roles' => [$role->id],
            ]);

        $response->assertRedirect(route('adminlte.users.index'));
        $this->assertDatabaseHas('users', [
            'first_name' => 'Carlos',
            'last_name' => 'Mendoza',
            'username' => 'carlosmendoza',
            'email' => 'carlos@example.com',
        ]);
    }
}
