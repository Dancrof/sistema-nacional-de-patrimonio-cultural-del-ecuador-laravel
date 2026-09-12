<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Sprint8MvpReadinessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_admin_area(): void
    {
        $response = $this->get(route('adminlte.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_user_with_artwork_permission_can_access_admin_artworks_index(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-artworks'], ['label' => 'Manage Artworks']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'username' => 'admin_mvp',
            'email' => 'admin.mvp@example.com',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('adminlte.artworks.index'));

        $response->assertOk();
    }

    public function test_regular_user_without_permission_is_forbidden_from_admin_artworks(): void
    {
        $user = User::factory()->create([
            'username' => 'viewer_user',
            'email' => 'viewer.user@example.com',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('adminlte.artworks.index'));

        $response->assertStatus(403);
    }
}
