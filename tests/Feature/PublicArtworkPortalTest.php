<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\ArtworkType;
use App\Models\Category;
use App\Models\Canton;
use App\Models\ConservationStatus;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtworkPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_lists_published_works_and_allows_detail_view(): void
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
            'code' => 'ART-200',
            'title' => 'La noche de Quito',
            'slug' => 'la-noche-de-quito',
            'description' => 'Obra representativa del centro histórico.',
            'short_description' => 'Pintura destacada.',
            'language' => 'es',
            'creation_year' => 1950,
            'status' => 'publicado',
            'published_at' => now(),
            'is_featured' => true,
        ]);
        $artwork->artists()->sync([$artist->id]);

        $catalogResponse = $this->get('/obras?search=Quito');
        $catalogResponse->assertOk();
        $catalogResponse->assertSee('La noche de Quito');

        $detailResponse = $this->get('/obras/' . $artwork->slug);
        $detailResponse->assertOk();
        $detailResponse->assertSee('La noche de Quito');
        $detailResponse->assertSee('Oswaldo Guayasamín');
    }
}
