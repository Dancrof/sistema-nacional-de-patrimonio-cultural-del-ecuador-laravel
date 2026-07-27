<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Province>
 */
class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->city();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'region' => fake()->randomElement(['Costa', 'Sierra', 'Amazonia', 'Insular']),
            'description' => fake()->optional()->paragraph(),
            'cover_image' => fake()->optional()->filePath(),
            'latitude' => fake()->optional()->latitude(-5, 1.5),
            'longitude' => fake()->optional()->longitude(-92, -75),
        ];
    }

    public function region(string $region): static
    {
        return $this->state(fn (array $attributes) => [
            'region' => $region,
        ]);
    }
}
