<?php

namespace Database\Factories;

use App\Models\Canton;
use App\Models\Parish;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Parish>
 */
class ParishFactory extends Factory
{
    protected $model = Parish::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->streetName();

        return [
            'canton_id' => Canton::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
