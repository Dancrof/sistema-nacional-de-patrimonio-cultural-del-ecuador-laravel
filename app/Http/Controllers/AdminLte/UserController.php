<?php

namespace App\Http\Controllers\AdminLte;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(): View
    {
        $this->authorizeManage();

        $users = User::with('roles')->latest()->paginate(15);

        return view('adminlte.users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorizeManage();

        $roles = Role::orderBy('name')->get();

        return view('adminlte.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'biography' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:adminlte_roles,id'],
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'biography' => $data['biography'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_created'));
    }

    public function edit(User $user): View
    {
        $this->authorizeManage();

        $roles = Role::orderBy('name')->get();
        $user->load('roles');

        return view('adminlte.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeManage();

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:4', 'max:50', 'unique:users,username,'.$user->id],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'biography' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:adminlte_roles,id'],
        ]);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'biography' => $data['biography'] ?? null,
            'is_active' => $data['is_active'] ?? $user->is_active,
            ...(isset($data['password']) && $data['password'] !== '' ? ['password' => Hash::make($data['password'])] : []),
        ]);

        $user->roles()->sync($data['roles'] ?? []);

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_updated'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->authorizeManage();

        $user->delete();

        return redirect()->route('adminlte.users.index')
            ->with('status', __('adminlte.user_deleted'));
    }

    private function authorizeManage(): void
    {
        abort_unless(auth()->user()?->hasPermission('manage-users'), 403);
    }
}
