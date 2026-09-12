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

class PublicArtworkAdvancedFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_filters_by_province_category_and_type(): void
    {
        $provinceA = Province::create(['name' => 'Pichincha', 'slug' => 'pichincha', 'region' => 'Sierra']);
        $provinceB = Province::create(['name' => 'Guayas', 'slug' => 'guayas', 'region' => 'Costa']);
        $cantonA = Canton::create(['province_id' => $provinceA->id, 'name' => 'Quito', 'slug' => 'quito']);
        $cantonB = Canton::create(['province_id' => $provinceB->id, 'name' => 'Guayaquil', 'slug' => 'guayaquil']);
        $categoryA = Category::create(['name' => 'Pinturas', 'slug' => 'pinturas', 'description' => 'Obras pictóricas']);
        $categoryB = Category::create(['name' => 'Escultura', 'slug' => 'escultura', 'description' => 'Obras tridimensionales']);
        $typeA = ArtworkType::create(['name' => 'Óleo sobre lienzo', 'slug' => 'oleo-sobre-lienzo', 'description' => 'Pintura al óleo']);
        $typeB = ArtworkType::create(['name' => 'Madera', 'slug' => 'madera', 'description' => 'Escultura en madera']);
        $statusA = ConservationStatus::create(['name' => 'Excelente', 'slug' => 'excelente', 'description' => 'Buen estado']);
        $statusB = ConservationStatus::create(['name' => 'Regular', 'slug' => 'regular', 'description' => 'Estado aceptable']);
        $artist = Artist::create([
            'first_name' => 'Oswaldo',
            'last_name' => 'Guayasamín',
            'full_name' => 'Oswaldo Guayasamín',
            'slug' => 'oswaldo-guayasamin',
            'nationality' => 'Ecuatoriana',
            'biography' => 'Artista ecuatoriano.',
        ]);

        $matching = Artwork::create([
            'category_id' => $categoryA->id,
            'conservation_status_id' => $statusA->id,
            'artwork_type_id' => $typeA->id,
            'province_id' => $provinceA->id,
            'canton_id' => $cantonA->id,
            'code' => 'ART-400',
            'title' => 'La noche de Quito',
            'slug' => 'la-noche-de-quito',
            'description' => 'Obra representativa.',
            'language' => 'es',
            'creation_year' => 1950,
            'status' => 'publicado',
            'published_at' => now(),
        ]);
        $matching->artists()->sync([$artist->id]);

        Artwork::create([
            'category_id' => $categoryB->id,
            'conservation_status_id' => $statusB->id,
            'artwork_type_id' => $typeB->id,
            'province_id' => $provinceB->id,
            'canton_id' => $cantonB->id,
            'code' => 'ART-401',
            'title' => 'El puerto',
            'slug' => 'el-puerto',
            'description' => 'Otra obra del litoral.',
            'language' => 'es',
            'creation_year' => 1970,
            'status' => 'publicado',
            'published_at' => now(),
        ]);

        $response = $this->get('/obras?province_id=' . $provinceA->id . '&category_id=' . $categoryA->id . '&artwork_type_id=' . $typeA->id);

        $response->assertOk();
        $response->assertSee('La noche de Quito');
        $response->assertDontSee('El puerto');
    }
}
