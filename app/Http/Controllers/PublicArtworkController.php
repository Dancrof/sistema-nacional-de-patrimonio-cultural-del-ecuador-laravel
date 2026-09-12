<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicArtworkController extends Controller
{
    public function index(Request $request): View
    {
        $query = Artwork::query()
            ->with(['category', 'province', 'canton', 'artists', 'artworkType'])
            ->where('status', 'publicado');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhereHas('artists', function ($artistQuery) use ($search) {
                        $artistQuery->where('full_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('artwork_type_id')) {
            $query->where('artwork_type_id', $request->artwork_type_id);
        }

        if ($request->filled('conservation_status_id')) {
            $query->where('conservation_status_id', $request->conservation_status_id);
        }

        $artworks = $query->latest('published_at')->paginate(12)->withQueryString();

        $provinces = \App\Models\Province::orderBy('name')->get();
        $categories = \App\Models\Category::orderBy('name')->get();
        $artworkTypes = \App\Models\ArtworkType::orderBy('name')->get();
        $statuses = \App\Models\ConservationStatus::orderBy('name')->get();

        return view('public.artworks.index', compact('artworks', 'provinces', 'categories', 'artworkTypes', 'statuses'));
    }

    public function show(string $slug): View
    {
        $artwork = Artwork::with(['category', 'province', 'canton', 'parish', 'artworkType', 'conservationStatus', 'artists', 'comments.user', 'ratings.user', 'images'])
            ->where('slug', $slug)
            ->where('status', 'publicado')
            ->firstOrFail();

        return view('public.artworks.show', compact('artwork'));
    }

    public function storeComment(Request $request, string $slug): RedirectResponse
    {
        $artwork = $this->findPublishedArtwork($slug);

        $data = $request->validate([
            'content' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        Comment::create([
            'artwork_id' => $artwork->id,
            'user_id' => auth()->id(),
            'content' => trim($data['content']),
            'is_approved' => true,
        ]);

        return redirect()->route('public.artworks.show', $artwork->slug)->with('status', 'Comentario publicado correctamente.');
    }

    public function storeRating(Request $request, string $slug): RedirectResponse
    {
        $artwork = $this->findPublishedArtwork($slug);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'review' => ['nullable', 'string', 'max:1000'],
        ]);

        Rating::updateOrCreate(
            [
                'artwork_id' => $artwork->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $data['rating'],
                'review' => $data['review'] ?? null,
            ]
        );

        $average = round((float) $artwork->ratings()->avg('rating') ?? 0, 2);
        $artwork->update(['average_rating' => $average]);

        return redirect()->route('public.artworks.show', $artwork->slug)->with('status', 'Valoración registrada correctamente.');
    }

    private function findPublishedArtwork(string $slug): Artwork
    {
        return Artwork::where('slug', $slug)
            ->where('status', 'publicado')
            ->firstOrFail();
    }
}
