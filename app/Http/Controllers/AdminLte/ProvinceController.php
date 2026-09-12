<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProvinceController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $provinces = Province::withCount('cantons')->latest()->paginate(15);

        return view('adminlte.provinces.index', compact('provinces'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        return view('adminlte.provinces.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:provinces,name'],
            'region' => ['required', 'string', 'in:Costa,Sierra,Amazonia,Insular'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        Province::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'region' => $data['region'],
            'description' => $data['description'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return redirect()->route('adminlte.provinces.index')->with('status', 'Provincia creada correctamente.');
    }

    public function edit(Province $province): View
    {
        $this->authorizeManage();

        return view('adminlte.provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:provinces,name,'.$province->id],
            'region' => ['required', 'string', 'in:Costa,Sierra,Amazonia,Insular'],
            'description' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $province->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'region' => $data['region'],
            'description' => $data['description'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);

        return redirect()->route('adminlte.provinces.index')->with('status', 'Provincia actualizada correctamente.');
    }

    public function destroy(Province $province): RedirectResponse
    {
        $this->authorizeManage();

        $province->delete();

        return redirect()->route('adminlte.provinces.index')->with('status', 'Provincia eliminada correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-geography'), 403);
    }
}
