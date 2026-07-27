<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, description: string}>
     */
    private const CATEGORIES = [
        [
            'name' => 'Pinturas',
            'description' => 'Obras pictóricas sobre diversos soportes y técnicas',
        ],
        [
            'name' => 'Esculturas',
            'description' => 'Obras tridimensionales en piedra, madera, bronce y otros materiales',
        ],
        [
            'name' => 'Arquitectura',
            'description' => 'Edificaciones y estructuras con valor artístico o histórico',
        ],
        [
            'name' => 'Monumentos',
            'description' => 'Monumentos conmemorativos y obras públicas destacadas',
        ],
        [
            'name' => 'Murales',
            'description' => 'Arte mural y pintura aplicada en muros y espacios urbanos',
        ],
        [
            'name' => 'Artesanías',
            'description' => 'Piezas artesanales y oficios tradicionales del patrimonio local',
        ],
        [
            'name' => 'Museos',
            'description' => 'Instituciones museísticas y espacios de exhibición cultural',
        ],
        [
            'name' => 'Patrimonio Cultural',
            'description' => 'Bienes y manifestaciones del patrimonio cultural ecuatoriano',
        ],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $category) {
            Category::query()->updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                ]
            );
        }
    }
}
