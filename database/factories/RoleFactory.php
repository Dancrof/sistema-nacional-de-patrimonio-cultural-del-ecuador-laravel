<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->jobTitle();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->optional()->sentence(),
        ];
    }

    public function administrador(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Administrador',
            'slug' => 'administrador',
            'description' => 'Acceso completo al sistema',
        ]);
    }

    public function curador(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Curador',
            'slug' => 'curador',
            'description' => 'Persona que sube y gestiona obras de arte',
        ]);
    }

    public function visitante(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Visitante',
            'slug' => 'visitante',
            'description' => 'Usuario con acceso de consulta y participación limitada',
        ]);
    }
}
