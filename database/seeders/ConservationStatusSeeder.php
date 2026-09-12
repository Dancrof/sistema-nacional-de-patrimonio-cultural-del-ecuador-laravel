<?php

namespace Database\Seeders;

use App\Models\ConservationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ConservationStatusSeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, description: string}>
     */
    private const STATUSES = [
        ['name' => 'Excelente', 'description' => 'Se conserva en muy buen estado y sin riesgos inmediatos'],
        ['name' => 'Bueno', 'description' => 'Presenta un estado aceptable con mantenimiento necesario'],
        ['name' => 'Regular', 'description' => 'Necesita supervisión y tratamiento de conservación'],
        ['name' => 'Malo', 'description' => 'Se observa deterioro importante y requiere intervención'],
        ['name' => 'Crítico', 'description' => 'Está en riesgo y requiere atención urgente'],
    ];

    public function run(): void
    {
        foreach (self::STATUSES as $status) {
            ConservationStatus::query()->updateOrCreate(
                ['slug' => Str::slug($status['name'])],
                [
                    'name' => $status['name'],
                    'description' => $status['description'],
                ]
            );
        }
    }
}
