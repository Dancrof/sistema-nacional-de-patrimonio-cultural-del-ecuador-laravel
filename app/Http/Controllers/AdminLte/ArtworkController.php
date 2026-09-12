<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\ArtworkType;
use App\Models\Category;
use App\Models\Canton;
use App\Models\ConservationStatus;
use App\Models\Province;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtworkController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $artworks = Artwork::with(['category', 'artworkType', 'conservationStatus', 'province', 'canton'])->latest()->paginate(15);

        return view('adminlte.artworks.index', compact('artworks'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $categories = Category::orderBy('name')->get();
        $artworkTypes = ArtworkType::orderBy('name')->get();
        $statuses = ConservationStatus::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $artists = Artist::orderBy('full_name')->get();

        return view('adminlte.artworks.create', compact('categories', 'artworkTypes', 'statuses', 'provinces', 'artists'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $this->normalizeCoordinateInputs($request);

        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'conservation_status_id' => ['nullable', 'integer', 'exists:conservation_statuses,id'],
            'artwork_type_id' => ['required', 'integer', 'exists:artwork_types,id'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'canton_id' => ['required', 'integer', 'exists:cantons,id'],
            'parish_id' => ['nullable', 'integer', 'exists:parishes,id'],
            'artist_ids' => ['nullable', 'array'],
            'artist_ids.*' => ['integer', 'exists:artists,id'],
            'code' => ['required', 'string', 'max:30', 'unique:artworks,code'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:255'],
            'creation_year' => ['nullable', 'integer', 'min:1000', 'max:2100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['nullable', 'in:borrador,pendiente,publicado,archivado'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $artwork = Artwork::create([
            'category_id' => $data['category_id'],
            'conservation_status_id' => $data['conservation_status_id'] ?? null,
            'artwork_type_id' => $data['artwork_type_id'],
            'province_id' => $data['province_id'],
            'canton_id' => $data['canton_id'],
            'parish_id' => $data['parish_id'] ?? null,
            'created_by' => auth()->id(),
            'code' => $data['code'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'],
            'language' => $data['language'] ?? 'es',
            'address' => $data['address'] ?? null,
            'creation_year' => $data['creation_year'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'status' => $data['status'] ?? 'borrador',
            'is_featured' => $data['is_featured'] ?? false,
        ]);

        if (! empty($data['artist_ids'])) {
            $artwork->artists()->sync($data['artist_ids']);
        }

        if (! empty($data['images'])) {
            $this->storeArtworkImages($artwork, $data['images']);
        }

        return redirect()->route('adminlte.artworks.index')->with('status', 'Obra creada correctamente.');
    }

    public function edit(Artwork $artwork): View
    {
        $this->authorizeManage();

        $artwork->load('artists');
        $categories = Category::orderBy('name')->get();
        $artworkTypes = ArtworkType::orderBy('name')->get();
        $statuses = ConservationStatus::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $artists = Artist::orderBy('full_name')->get();
        $cantons = Canton::where('province_id', $artwork->province_id)->orderBy('name')->get();

        return view('adminlte.artworks.edit', compact('artwork', 'categories', 'artworkTypes', 'statuses', 'provinces', 'cantons', 'artists'));
    }

    public function update(Request $request, Artwork $artwork): RedirectResponse
    {
        $this->authorizeManage();

        $this->normalizeCoordinateInputs($request);

        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'conservation_status_id' => ['nullable', 'integer', 'exists:conservation_statuses,id'],
            'artwork_type_id' => ['required', 'integer', 'exists:artwork_types,id'],
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'canton_id' => ['required', 'integer', 'exists:cantons,id'],
            'parish_id' => ['nullable', 'integer', 'exists:parishes,id'],
            'artist_ids' => ['nullable', 'array'],
            'artist_ids.*' => ['integer', 'exists:artists,id'],
            'code' => ['required', 'string', 'max:30', 'unique:artworks,code,'.$artwork->id],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:10'],
            'address' => ['nullable', 'string', 'max:255'],
            'creation_year' => ['nullable', 'integer', 'min:1000', 'max:2100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['nullable', 'in:borrador,pendiente,publicado,archivado'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $artwork->update([
            'category_id' => $data['category_id'],
            'conservation_status_id' => $data['conservation_status_id'] ?? null,
            'artwork_type_id' => $data['artwork_type_id'],
            'province_id' => $data['province_id'],
            'canton_id' => $data['canton_id'],
            'parish_id' => $data['parish_id'] ?? null,
            'updated_by' => auth()->id(),
            'code' => $data['code'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'],
            'language' => $data['language'] ?? 'es',
            'address' => $data['address'] ?? null,
            'creation_year' => $data['creation_year'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'status' => $data['status'] ?? 'borrador',
            'is_featured' => $data['is_featured'] ?? false,
        ]);

        if (! empty($data['artist_ids'])) {
            $artwork->artists()->sync($data['artist_ids']);
        } else {
            $artwork->artists()->detach();
        }

        if ($request->hasFile('images')) {
            foreach ($artwork->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }

            $this->storeArtworkImages($artwork, $data['images']);
        }

        return redirect()->route('adminlte.artworks.index')->with('status', 'Obra actualizada correctamente.');
    }

    public function destroy(Artwork $artwork): RedirectResponse
    {
        $this->authorizeManage();

        $artwork->delete();

        return redirect()->route('adminlte.artworks.index')->with('status', 'Obra eliminada correctamente.');
    }

    private function storeArtworkImages(Artwork $artwork, array $images): void
    {
        foreach ($images as $index => $file) {
            $path = $file->store('artworks', 'public');

            $artwork->images()->create([
                'photographer' => auth()->user()?->name,
                'image_path' => $path,
                'caption' => $artwork->title,
                'alt_text' => $artwork->title,
                'file_size' => $file->getSize(),
                'width' => null,
                'height' => null,
                'mime_type' => $file->getMimeType(),
                'image_hash' => hash_file('sha256', $file->getRealPath()),
                'display_order' => $index + 1,
                'is_cover' => $index === 0,
            ]);
        }
    }

    private function normalizeCoordinateInputs(Request $request): void
    {
        foreach (['latitude', 'longitude'] as $field) {
            if ($request->filled($field)) {
                $value = trim((string) $request->input($field));
                $request->merge([$field => str_replace(',', '.', $value)]);
            }
        }
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-artworks'), 403);
    }
}
