<?php

namespace App\Models\Concerns;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Adds role and permission helpers to the User model.
 */
trait HasRoles
{
    /**
     * Roles assigned to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'adminlte_role_user');
    }

    /**
     * Determine whether the user has any of the given role(s).
     *
     * @param  string|array<int, string>  $role
     */
    public function hasRole(string|array $role): bool
    {
        $roles = array_map(fn (string $name) => $this->normalizeRoleName($name), (array) $role);

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Determine whether any of the user's roles grants the given permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->where('name', $permission))
            ->exists();
    }

    /**
     * Assign a role to the user by name without detaching existing roles.
     */
    public function assignRole(string $role): void
    {
        $resolvedRole = $this->resolveRole($role);

        if ($resolvedRole !== null) {
            $this->roles()->syncWithoutDetaching($resolvedRole);
        }
    }

    protected function resolveRole(string $role): ?Role
    {
        $normalized = $this->normalizeRoleName($role);

        return Role::whereIn('name', [$normalized, $role, $this->normalizeRoleAlias($role)])
            ->first();
    }

    protected function normalizeRoleName(string $role): string
    {
        return match ($role) {
            'administrador', 'admin' => 'admin',
            'gestor', 'manager' => 'gestor',
            'moderador', 'moderator' => 'moderador',
            'usuario', 'user', 'viewer' => 'usuario',
            default => strtolower($role),
        };
    }

    protected function normalizeRoleAlias(string $role): string
    {
        return match ($this->normalizeRoleName($role)) {
            'admin' => 'administrador',
            'gestor' => 'manager',
            'moderador' => 'moderator',
            'usuario' => 'viewer',
            default => $role,
        };
    }

    /**
     * Determine whether the user has the "admin" role.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
