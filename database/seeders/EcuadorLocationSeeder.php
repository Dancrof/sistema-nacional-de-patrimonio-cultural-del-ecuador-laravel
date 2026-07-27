<?php

namespace Database\Seeders;

use App\Models\Canton;
use App\Models\Parish;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class EcuadorLocationSeeder extends Seeder
{
    /**
     * @var array<string, array{name: string, region: string}>
     */
    private const PROVINCE_METADATA = [
        '1' => ['name' => 'Azuay', 'region' => 'Sierra'],
        '2' => ['name' => 'Bolívar', 'region' => 'Sierra'],
        '3' => ['name' => 'Cañar', 'region' => 'Sierra'],
        '4' => ['name' => 'Carchi', 'region' => 'Sierra'],
        '5' => ['name' => 'Cotopaxi', 'region' => 'Sierra'],
        '6' => ['name' => 'Chimborazo', 'region' => 'Sierra'],
        '7' => ['name' => 'El Oro', 'region' => 'Costa'],
        '8' => ['name' => 'Esmeraldas', 'region' => 'Costa'],
        '9' => ['name' => 'Guayas', 'region' => 'Costa'],
        '10' => ['name' => 'Imbabura', 'region' => 'Sierra'],
        '11' => ['name' => 'Loja', 'region' => 'Sierra'],
        '12' => ['name' => 'Los Ríos', 'region' => 'Costa'],
        '13' => ['name' => 'Manabí', 'region' => 'Costa'],
        '14' => ['name' => 'Morona Santiago', 'region' => 'Amazonia'],
        '15' => ['name' => 'Napó', 'region' => 'Amazonia'],
        '16' => ['name' => 'Pastaza', 'region' => 'Amazonia'],
        '17' => ['name' => 'Pichincha', 'region' => 'Sierra'],
        '18' => ['name' => 'Tungurahua', 'region' => 'Sierra'],
        '19' => ['name' => 'Zamora Chinchipe', 'region' => 'Amazonia'],
        '20' => ['name' => 'Galápagos', 'region' => 'Insular'],
        '21' => ['name' => 'Sucumbíos', 'region' => 'Amazonia'],
        '22' => ['name' => 'Orellana', 'region' => 'Amazonia'],
        '23' => ['name' => 'Santo Domingo de los Tsáchilas', 'region' => 'Costa'],
        '24' => ['name' => 'Santa Elena', 'region' => 'Costa'],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $divisions = $this->loadDivisions();

        DB::transaction(function () use ($divisions): void {
            $now = now();
            $parishRows = [];

            foreach ($divisions as $provinceCode => $division) {
                if (! isset($division['provincia'], self::PROVINCE_METADATA[$provinceCode])) {
                    continue;
                }

                $metadata = self::PROVINCE_METADATA[$provinceCode];
                $province = Province::query()->updateOrCreate(
                    ['slug' => Str::slug($metadata['name'])],
                    [
                        'name' => $metadata['name'],
                        'region' => $metadata['region'],
                    ]
                );

                foreach ($division['cantones'] as $cantonData) {
                    $cantonName = $this->normalizeName($cantonData['canton']);

                    $canton = Canton::query()->updateOrCreate(
                        [
                            'province_id' => $province->id,
                            'name' => $cantonName,
                        ],
                        [
                            'slug' => Str::slug($cantonName),
                        ]
                    );

                    if (! is_array($cantonData['parroquias'] ?? null)) {
                        continue;
                    }

                    foreach ($cantonData['parroquias'] as $parishName) {
                        $normalizedParishName = $this->normalizeName($parishName);

                        $parishRows[] = [
                            'canton_id' => $canton->id,
                            'name' => $normalizedParishName,
                            'slug' => Str::slug($normalizedParishName),
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }
                }
            }

            foreach (array_chunk($parishRows, 500) as $chunk) {
                Parish::query()->upsert(
                    $chunk,
                    ['canton_id', 'name'],
                    ['slug', 'updated_at']
                );
            }
        });
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function loadDivisions(): array
    {
        $path = database_path('data/ecuador_divisions.json');

        if (! is_file($path)) {
            throw new RuntimeException("No se encontró el archivo de divisiones administrativas: {$path}");
        }

        $divisions = json_decode(file_get_contents($path), true);

        if (! is_array($divisions)) {
            throw new RuntimeException('El archivo ecuador_divisions.json no contiene un JSON válido.');
        }

        return $divisions;
    }

    private function normalizeName(string $name): string
    {
        return mb_convert_case(mb_strtolower(trim($name), 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }
}
