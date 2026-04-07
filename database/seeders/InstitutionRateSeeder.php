<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\Rate;
use Illuminate\Database\Seeder;

class InstitutionRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            [
                'name' => 'Nu Mexico',
                'logo' => 'https://example.com/logos/nu-mexico.svg',
                'rates' => [
                    [
                        'name' => 'Cuenta Nu - Base',
                        'annual_rate' => 12.50,
                        'type' => 'none',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => null,
                        'sort_order' => 1,
                        'description' => 'Tasa base para saldo disponible en cuenta.',
                        'frecuency' => 'daily',
                    ],
                    [
                        'name' => 'Cuenta Nu - Saldo Promocional',
                        'annual_rate' => 14.10,
                        'type' => 'amount',
                        'min_amount' => 1000.00,
                        'max_amount' => 50000.00,
                        'days' => null,
                        'sort_order' => 2,
                        'description' => 'Aplica para saldos promocionales dentro del rango.',
                        'frecuency' => 'daily',
                    ],
                    [
                        'name' => 'Cajita Nu - 90 dias',
                        'annual_rate' => 13.25,
                        'type' => 'term',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => 90,
                        'sort_order' => 3,
                        'description' => 'Rendimiento estimado para inversion a 90 dias.',
                        'frecuency' => 'simple',
                    ],
                ],
            ],
            [
                'name' => 'BBVA Mexico',
                'logo' => 'https://example.com/logos/bbva-mexico.svg',
                'rates' => [
                    [
                        'name' => 'Inversion BBVA - 28 dias',
                        'annual_rate' => 9.80,
                        'type' => 'term',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => 28,
                        'sort_order' => 1,
                        'description' => 'Inversion a corto plazo para nuevos clientes.',
                        'frecuency' => 'monthly',
                    ],
                    [
                        'name' => 'Inversion BBVA - 180 dias',
                        'annual_rate' => 10.90,
                        'type' => 'term',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => 180,
                        'sort_order' => 2,
                        'description' => 'Inversion de plazo medio con tasa preferencial.',
                        'frecuency' => 'monthly',
                    ],
                    [
                        'name' => 'Cuenta Meta BBVA',
                        'annual_rate' => 7.25,
                        'type' => 'none',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => null,
                        'sort_order' => 3,
                        'description' => 'Tasa para ahorro programado sin plazo fijo.',
                        'frecuency' => 'daily',
                    ],
                ],
            ],
            [
                'name' => 'Banamex',
                'logo' => 'https://example.com/logos/banamex.svg',
                'rates' => [
                    [
                        'name' => 'Pagaré Banamex - 30 dias',
                        'annual_rate' => 8.70,
                        'type' => 'term',
                        'min_amount' => null,
                        'max_amount' => null,
                        'days' => 30,
                        'sort_order' => 1,
                        'description' => 'Pagaré bancario con vencimiento a 30 dias.',
                        'frecuency' => 'simple',
                    ],
                    [
                        'name' => 'Pagaré Banamex - Rango Plus',
                        'annual_rate' => 10.10,
                        'type' => 'amount',
                        'min_amount' => 50000.00,
                        'max_amount' => 250000.00,
                        'days' => null,
                        'sort_order' => 2,
                        'description' => 'Tasa preferencial para montos altos.',
                        'frecuency' => 'simple',
                    ],
                ],
            ],
        ];

        foreach ($institutions as $institutionData) {
            $rates = $institutionData['rates'];
            unset($institutionData['rates']);

            $institution = Institution::updateOrCreate(
                ['name' => $institutionData['name']],
                $institutionData,
            );

            foreach ($rates as $rateData) {
                Rate::updateOrCreate(
                    [
                        'institution_id' => $institution->id,
                        'name' => $rateData['name'],
                    ],
                    $rateData,
                );
            }
        }
    }
}
