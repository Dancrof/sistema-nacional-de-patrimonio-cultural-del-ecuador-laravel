<?php

namespace Database\Factories;

use App\Models\Canton;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Canton>
 */
class CantonFactory extends Factory
{
    protected $model = Canton::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->city();

        return [
            'province_id' => Province::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
