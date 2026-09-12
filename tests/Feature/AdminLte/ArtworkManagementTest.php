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

    public function test_admin_cannot_create_an_artwork_without_images(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-artworks'], ['label' => 'Manage Artworks']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Image',
            'name' => 'Admin Image',
            'username' => 'admin_image',
            'email' => 'admin.image@example.com',
        ]);
        $admin->assignRole('admin');

        $province = Province::create(['name' => 'Loja', 'slug' => 'loja', 'region' => 'Sierra']);
        $canton = Canton::create(['province_id' => $province->id, 'name' => 'Loja', 'slug' => 'loja']);
        $category = Category::create(['name' => 'Fotografía', 'slug' => 'fotografia', 'description' => 'Imágenes']);
        $type = ArtworkType::create(['name' => 'Fotografía documental', 'slug' => 'fotografia-documental', 'description' => 'Fotografía']);

        $response = $this->actingAs($admin)
            ->from(route('adminlte.artworks.create'))
            ->post(route('adminlte.artworks.store'), [
                'category_id' => $category->id,
                'artwork_type_id' => $type->id,
                'province_id' => $province->id,
                'canton_id' => $canton->id,
                'code' => 'ART-IMG-001',
                'title' => 'Paisaje sin imagen',
                'description' => 'Debe fallar porque no se adjuntó ninguna imagen.',
            ]);

        $response->assertSessionHasErrors('images');
        $this->assertDatabaseMissing('artworks', ['code' => 'ART-IMG-001']);
    }

    public function test_admin_can_create_an_artwork_with_related_videos(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'manage-artworks'], ['label' => 'Manage Artworks']);
        $role = Role::firstOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $role->permissions()->syncWithoutDetaching([$permission->id]);

        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Video',
            'name' => 'Admin Video',
            'username' => 'admin_video',
            'email' => 'admin.video@example.com',
        ]);
        $admin->assignRole('admin');

        $province = Province::create(['name' => 'Guayas', 'slug' => 'guayas', 'region' => 'Costa']);
        $canton = Canton::create(['province_id' => $province->id, 'name' => 'Guayaquil', 'slug' => 'guayaquil']);
        $category = Category::create(['name' => 'Escultura', 'slug' => 'escultura', 'description' => 'Obras de escultura']);
        $type = ArtworkType::create(['name' => 'Escultura en metal', 'slug' => 'escultura-en-metal', 'description' => 'Escultura']);

        Storage::fake('public');

        $response = $this->actingAs($admin)
            ->post(route('adminlte.artworks.store'), [
                'category_id' => $category->id,
                'artwork_type_id' => $type->id,
                'province_id' => $province->id,
                'canton_id' => $canton->id,
                'code' => 'ART-VIDEO-001',
                'title' => 'Monumento del río',
                'description' => 'Escultura urbana acompañada de video documental.',
                'images' => [File::image('video-cover.jpg')],
                'videos' => [[
                    'title' => 'Video documental',
                    'video_url' => 'https://www.youtube.com/watch?v=abc123',
                    'thumbnail' => 'https://img.youtube.com/vi/abc123/hqdefault.jpg',
                    'duration' => '00:03:45',
                    'provider' => 'youtube',
                ]],
            ]);

        $response->assertRedirect(route('adminlte.artworks.index'));
        $this->assertDatabaseHas('artwork_videos', [
            'title' => 'Video documental',
            'video_url' => 'https://www.youtube.com/watch?v=abc123',
            'provider' => 'youtube',
        ]);
    }
}
