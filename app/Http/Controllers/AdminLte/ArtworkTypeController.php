<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\ArtworkType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtworkTypeController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $artworkTypes = ArtworkType::latest()->paginate(15);

        return view('adminlte.artwork-types.index', compact('artworkTypes'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        return view('adminlte.artwork-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:artwork_types,name'],
            'description' => ['nullable', 'string'],
        ]);

        ArtworkType::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.artwork-types.index')->with('status', 'Tipo de obra creado correctamente.');
    }

    public function edit(ArtworkType $artworkType): View
    {
        $this->authorizeManage();

        return view('adminlte.artwork-types.edit', compact('artworkType'));
    }

    public function update(Request $request, ArtworkType $artworkType): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:artwork_types,name,'.$artworkType->id],
            'description' => ['nullable', 'string'],
        ]);

        $artworkType->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.artwork-types.index')->with('status', 'Tipo de obra actualizado correctamente.');
    }

    public function destroy(ArtworkType $artworkType): RedirectResponse
    {
        $this->authorizeManage();

        $artworkType->delete();

        return redirect()->route('adminlte.artwork-types.index')->with('status', 'Tipo de obra eliminado correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-catalogs'), 403);
    }
}
