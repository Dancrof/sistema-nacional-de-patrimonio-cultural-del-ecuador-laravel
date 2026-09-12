<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $artists = Artist::orderBy('full_name')->paginate(15);

        return view('adminlte.artists.index', compact('artists'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        return view('adminlte.artists.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:150'],
            'death_date' => ['nullable', 'date'],
            'is_deceased' => ['nullable', 'boolean'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'biography' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $fullName = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        Artist::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'full_name' => $fullName,
            'slug' => Str::slug($fullName),
            'birth_date' => $data['birth_date'] ?? null,
            'birth_place' => $data['birth_place'] ?? null,
            'death_date' => $data['death_date'] ?? null,
            'is_deceased' => $data['is_deceased'] ?? false,
            'nationality' => $data['nationality'] ?? null,
            'biography' => $data['biography'] ?? null,
            'website' => $data['website'] ?? null,
        ]);

        return redirect()->route('adminlte.artists.index')->with('status', 'Artista creado correctamente.');
    }

    public function edit(Artist $artist): View
    {
        $this->authorizeManage();

        return view('adminlte.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'birth_place' => ['nullable', 'string', 'max:150'],
            'death_date' => ['nullable', 'date'],
            'is_deceased' => ['nullable', 'boolean'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'biography' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
        ]);

        $fullName = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));

        $artist->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'full_name' => $fullName,
            'slug' => Str::slug($fullName),
            'birth_date' => $data['birth_date'] ?? null,
            'birth_place' => $data['birth_place'] ?? null,
            'death_date' => $data['death_date'] ?? null,
            'is_deceased' => $data['is_deceased'] ?? false,
            'nationality' => $data['nationality'] ?? null,
            'biography' => $data['biography'] ?? null,
            'website' => $data['website'] ?? null,
        ]);

        return redirect()->route('adminlte.artists.index')->with('status', 'Artista actualizado correctamente.');
    }

    public function destroy(Artist $artist): RedirectResponse
    {
        $this->authorizeManage();

        $artist->delete();

        return redirect()->route('adminlte.artists.index')->with('status', 'Artista eliminado correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-artists'), 403);
    }
}
