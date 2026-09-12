<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\ConservationStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConservationStatusController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $conservationStatuses = ConservationStatus::latest()->paginate(15);

        return view('adminlte.conservation-statuses.index', compact('conservationStatuses'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        return view('adminlte.conservation-statuses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:conservation_statuses,name'],
            'description' => ['nullable', 'string'],
        ]);

        ConservationStatus::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.conservation-statuses.index')->with('status', 'Estado de conservación creado correctamente.');
    }

    public function edit(ConservationStatus $conservationStatus): View
    {
        $this->authorizeManage();

        return view('adminlte.conservation-statuses.edit', compact('conservationStatus'));
    }

    public function update(Request $request, ConservationStatus $conservationStatus): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:conservation_statuses,name,'.$conservationStatus->id],
            'description' => ['nullable', 'string'],
        ]);

        $conservationStatus->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.conservation-statuses.index')->with('status', 'Estado de conservación actualizado correctamente.');
    }

    public function destroy(ConservationStatus $conservationStatus): RedirectResponse
    {
        $this->authorizeManage();

        $conservationStatus->delete();

        return redirect()->route('adminlte.conservation-statuses.index')->with('status', 'Estado de conservación eliminado correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-catalogs'), 403);
    }
}
