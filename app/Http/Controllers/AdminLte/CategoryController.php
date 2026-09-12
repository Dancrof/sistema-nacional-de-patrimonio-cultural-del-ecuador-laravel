<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $categories = Category::latest()->paginate(15);

        return view('adminlte.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        return view('adminlte.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.categories.index')->with('status', 'Categoría creada correctamente.');
    }

    public function edit(Category $category): View
    {
        $this->authorizeManage();

        return view('adminlte.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categories,name,'.$category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return redirect()->route('adminlte.categories.index')->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorizeManage();

        $category->delete();

        return redirect()->route('adminlte.categories.index')->with('status', 'Categoría eliminada correctamente.');
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-catalogs'), 403);
    }
}
