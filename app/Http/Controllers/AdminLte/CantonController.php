<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Canton;
use App\Models\Province;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CantonController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $cantons = Canton::with('province')->latest()->paginate(15);

        return view('adminlte.cantons.index', compact('cantons'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $provinces = Province::orderBy('name')->get();

        return view('adminlte.cantons.create', compact('provinces'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        Canton::query()->firstOrCreate(
            [
                'province_id' => $data['province_id'],
                'name' => $data['name'],
            ],
            ['slug' => Str::slug($data['name'])]
        );

        return redirect()->route('adminlte.cantons.index')->with('status', 'Cantón registrado correctamente.');
    }

    public function edit(Canton $canton): View
    {
        $this->authorizeManage();

        $provinces = Province::orderBy('name')->get();

        return view('adminlte.cantons.edit', compact('canton', 'provinces'));
    }

    public function update(Request $request, Canton $canton): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'province_id' => ['required', 'integer', 'exists:provinces,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        $canton->update([
            'province_id' => $data['province_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return redirect()->route('adminlte.cantons.index')->with('status', 'Cantón actualizado correctamente.');
    }

    public function destroy(Canton $canton): RedirectResponse
    {
        $this->authorizeManage();

        $canton->delete();

        return redirect()->route('adminlte.cantons.index')->with('status', 'Cantón eliminado correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-geography'), 403);
    }
}
