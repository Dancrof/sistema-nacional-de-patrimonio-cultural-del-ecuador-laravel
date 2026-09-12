<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\ArtworkImage;
use App\Models\ArtworkType;
use App\Models\Category;
use App\Models\Canton;
use App\Models\ConservationStatus;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtworkGalleryAndLocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_detail_shows_gallery_and_coordinates_for_an_artwork(): void
    {
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

        $artwork = Artwork::create([
            'category_id' => $category->id,
            'conservation_status_id' => $status->id,
            'artwork_type_id' => $type->id,
            'province_id' => $province->id,
            'canton_id' => $canton->id,
            'code' => 'ART-300',
            'title' => 'La noche de Quito',
            'slug' => 'la-noche-de-quito',
            'description' => 'Obra representativa del centro histórico.',
            'short_description' => 'Pintura destacada.',
            'language' => 'es',
            'creation_year' => 1950,
            'status' => 'publicado',
            'published_at' => now(),
            'is_featured' => true,
            'latitude' => '-0.180653',
            'longitude' => '-78.467838',
        ]);
        $artwork->artists()->sync([$artist->id]);

        ArtworkImage::create([
            'artwork_id' => $artwork->id,
            'image_path' => 'storage/test/cover.jpg',
            'caption' => 'Vista del cuadro',
            'alt_text' => 'Imagen de la obra',
            'display_order' => 1,
            'is_cover' => true,
        ]);

        $response = $this->get('/obras/' . $artwork->slug);

        $response->assertOk();
        $response->assertSee('Vista del cuadro');
        $response->assertSee('-0.180653');
        $response->assertSee('-78.467838');
    }
}
