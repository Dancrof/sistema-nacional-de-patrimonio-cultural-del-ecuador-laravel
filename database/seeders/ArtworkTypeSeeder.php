<?php

namespace Database\Seeders;

use App\Models\ArtworkType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArtworkTypeSeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, description: string}>
     */
    private const TYPES = [
        ['name' => 'Pintura', 'description' => 'Obra pictórica realizada sobre un soporte'],
        ['name' => 'Escultura', 'description' => 'Obra tridimensional elaborada en volumen'],
        ['name' => 'Arquitectura', 'description' => 'Edificación o espacio de valor patrimonial'],
        ['name' => 'Fotografía', 'description' => 'Registro visual de valor documental o artístico'],
        ['name' => 'Textil', 'description' => 'Obra confeccionada en materiales textiles'],
        ['name' => 'Cerámica', 'description' => 'Obra modelada o decorada en cerámica'],
    ];

    public function run(): void
    {
        foreach (self::TYPES as $type) {
            ArtworkType::query()->updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                [
                    'name' => $type['name'],
                    'description' => $type['description'],
                ]
            );
        }
    }
}
