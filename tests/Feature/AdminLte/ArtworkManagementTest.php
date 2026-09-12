<?php

namespace Tests\Feature\AdminLte;

use App\Models\Artist;
use App\Models\ArtworkType;
use App\Models\Category;
use App\Models\Canton;
use App\Models\ConservationStatus;
use App\Models\Permission;
use App\Models\Province;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtworkManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_artwork_with_related_catalogs_and_location(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-artworks'], ['label' => 'Manage Artworks']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Artwork',
            'name' => 'Admin Artwork',
            'username' => 'admin_artwork',
            'email' => 'admin.artwork@example.com',
        ]);
        $admin->assignRole('admin');

        $province = Province::create(['name' => 'Pichincha', 'slug' => 'pichincha', 'region' => 'Sierra']);
        $canton = Canton::create(['province_id' => $province->id, 'name' => 'Quito', 'slug' => 'quito']);
        $category = Category::create(['name' => 'Pinturas', 'slug' => 'pinturas', 'description' => 'Obras pictóricas']);
        $type = ArtworkType::create(['name' => 'Óleo sobre lienzo', 'slug' => 'oleo-sobre-lienzo', 'description' => 'Pintura al óleo']);
        $status = ConservationStatus::create(['name' => 'Excelente', 'slug' => 'excelente', 'description' => 'Buen estado']);
        $artist = Artist::create([
            'first_name' => 'Oswaldo',
            'last_name' => 'Guayasamín',
            'full_name' => 'Oswaldo Guayasamín',
            'slug' => 'oswaldo-guayasamin',
            'nationality' => 'Ecuatoriana',
            'biography' => 'Artista ecuatoriano.',
        ]);

        Storage::fake('public');

        $response = $this->actingAs($admin)
            ->post(route('adminlte.artworks.store'), [
                'category_id' => $category->id,
                'artwork_type_id' => $type->id,
                'conservation_status_id' => $status->id,
                'province_id' => $province->id,
                'canton_id' => $canton->id,
                'artist_ids' => [$artist->id],
                'code' => 'ART-001',
                'title' => 'La noche de Quito',
                'description' => 'Obra representativa del centro histórico.',
                'language' => 'es',
                'creation_year' => 1950,
                'status' => 'publicado',
                'is_featured' => true,
                'latitude' => '-0,1807',
                'longitude' => '-78,4678',
                'images' => [
                    File::image('front.jpg'),
                    File::image('detail.jpg'),
                ],
            ]);

        $response->assertRedirect(route('adminlte.artworks.index'));
        $this->assertDatabaseHas('artworks', [
            'code' => 'ART-001',
            'title' => 'La noche de Quito',
            'slug' => 'la-noche-de-quito',
            'status' => 'publicado',
            'latitude' => '-0.1807',
            'longitude' => '-78.4678',
        ]);
        $this->assertDatabaseHas('artwork_images', ['artwork_id' => 1, 'is_cover' => true]);
        $this->assertDatabaseCount('artwork_images', 2);
    }
}
