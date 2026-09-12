<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\ArtworkType;
use App\Models\Category;
use App\Models\Canton;
use App\Models\ConservationStatus;
use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicArtworkInteractionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_comment_and_rate_a_published_artwork(): void
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
            'code' => 'ART-210',
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

        $user = User::factory()->create([
            'email' => 'viewer@example.com',
            'username' => 'viewer_user',
            'name' => 'Viewer User',
        ]);

        $commentResponse = $this->actingAs($user)
            ->post(route('public.artworks.comments.store', $artwork->slug), [
                'content' => 'Excelente pieza para el patrimonio ecuatoriano.',
            ]);

        $commentResponse->assertRedirect(route('public.artworks.show', $artwork->slug));
        $this->assertDatabaseHas('comments', [
            'artwork_id' => $artwork->id,
            'user_id' => $user->id,
            'content' => 'Excelente pieza para el patrimonio ecuatoriano.',
        ]);

        $ratingResponse = $this->actingAs($user)
            ->post(route('public.artworks.ratings.store', $artwork->slug), [
                'rating' => 5,
                'review' => 'Muy recomendable',
            ]);

        $ratingResponse->assertRedirect(route('public.artworks.show', $artwork->slug));
        $this->assertDatabaseHas('ratings', [
            'artwork_id' => $artwork->id,
            'user_id' => $user->id,
            'rating' => 5,
            'review' => 'Muy recomendable',
        ]);

        $this->assertDatabaseHas('artworks', [
            'id' => $artwork->id,
            'average_rating' => 5.00,
        ]);
    }
}
