<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Canton;
use App\Models\Parish;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParishController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $parishes = Parish::with('canton.province')->latest()->paginate(15);

        return view('adminlte.parishes.index', compact('parishes'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $cantons = Canton::with('province')->orderBy('name')->get();

        return view('adminlte.parishes.create', compact('cantons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'canton_id' => ['required', 'integer', 'exists:cantons,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        Parish::query()->firstOrCreate(
            [
                'canton_id' => $data['canton_id'],
                'name' => $data['name'],
            ],
            ['slug' => Str::slug($data['name'])]
        );

        return redirect()->route('adminlte.parishes.index')->with('status', 'Parroquia registrada correctamente.');
    }

    public function edit(Parish $parish): View
    {
        $this->authorizeManage();

        $cantons = Canton::with('province')->orderBy('name')->get();

        return view('adminlte.parishes.edit', compact('parish', 'cantons'));
    }

    public function update(Request $request, Parish $parish): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'canton_id' => ['required', 'integer', 'exists:cantons,id'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        $parish->update([
            'canton_id' => $data['canton_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return redirect()->route('adminlte.parishes.index')->with('status', 'Parroquia actualizada correctamente.');
    }

    public function destroy(Parish $parish): RedirectResponse
    {
        $this->authorizeManage();

        $parish->delete();

        return redirect()->route('adminlte.parishes.index')->with('status', 'Parroquia eliminada correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-geography'), 403);
    }
}
