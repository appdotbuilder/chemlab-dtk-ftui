<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Equipment>
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $equipmentData = [
            // Lab OTK Equipment
            [
                'name' => 'Rotary Evaporator Heidolph',
                'category' => 'Pemisahan',
                'brand' => 'Heidolph',
                'specifications' => 'Kapasitas 1L, suhu maksimal 180°C, vakum hingga 1 mbar',
                'risk_level' => Equipment::RISK_MEDIUM,
            ],
            [
                'name' => 'Spektrofotometer UV-Vis',
                'category' => 'Analisis',
                'brand' => 'Shimadzu',
                'specifications' => 'Range 190-900nm, presisi ±0.3nm, bandwidth 2nm',
                'risk_level' => Equipment::RISK_LOW,
            ],
            [
                'name' => 'HPLC System',
                'category' => 'Kromatografi',
                'brand' => 'Waters',
                'specifications' => 'Pump Binary, Autosampler, DAD Detector, kolom C18',
                'risk_level' => Equipment::RISK_HIGH,
            ],
            [
                'name' => 'pH Meter Digital',
                'category' => 'Pengukuran',
                'brand' => 'Hanna Instruments',
                'specifications' => 'Range pH 0-14, akurasi ±0.01 pH, kalibrasi otomatis',
                'risk_level' => Equipment::RISK_LOW,
            ],
            [
                'name' => 'Timbangan Analitik',
                'category' => 'Pengukuran',
                'brand' => 'Sartorius',
                'specifications' => 'Kapasitas 220g, readability 0.1mg, kalibrasi internal',
                'risk_level' => Equipment::RISK_MEDIUM,
            ],
            [
                'name' => 'Hot Plate Magnetic Stirrer',
                'category' => 'Heating',
                'brand' => 'IKA',
                'specifications' => 'Suhu maksimal 340°C, kecepatan pengadukan 100-1500 rpm',
                'risk_level' => Equipment::RISK_MEDIUM,
            ],
            [
                'name' => 'Centrifuge',
                'category' => 'Pemisahan',
                'brand' => 'Eppendorf',
                'specifications' => 'Kecepatan maksimal 15000 rpm, kapasitas 24 tabung',
                'risk_level' => Equipment::RISK_MEDIUM,
            ],
            [
                'name' => 'Oven Laboratorium',
                'category' => 'Heating',
                'brand' => 'Memmert',
                'specifications' => 'Suhu kerja 5-300°C, volume 53L, sirkulasi udara paksa',
                'risk_level' => Equipment::RISK_MEDIUM,
            ],
        ];

        static $index = 0;
        $equipment = $equipmentData[$index % count($equipmentData)];
        $index++;

        $assetNumber = str_pad((string) fake()->unique()->numberBetween(1001, 9999), 4, '0', STR_PAD_LEFT);

        return array_merge($equipment, [
            'lab_id' => Lab::factory(),
            'asset_code' => 'DTK-' . $assetNumber,
            'serial_number' => strtoupper(fake()->lexify('??###??')),
            'image_url' => 'https://via.placeholder.com/400x300/1f2937/ffffff?text=' . urlencode($equipment['name']),
            'documents' => [
                [
                    'name' => 'Manual Operasi',
                    'url' => '/documents/manual-' . $assetNumber . '.pdf',
                    'type' => 'PDF'
                ],
                [
                    'name' => 'Sertifikat Kalibrasi',
                    'url' => '/documents/cert-' . $assetNumber . '.pdf',
                    'type' => 'PDF'
                ]
            ],
            'status' => fake()->randomElement([
                Equipment::STATUS_AVAILABLE,
                Equipment::STATUS_AVAILABLE,
                Equipment::STATUS_AVAILABLE,
                Equipment::STATUS_BORROWED,
                Equipment::STATUS_MAINTENANCE,
            ]),
            'next_maintenance_date' => fake()->dateTimeBetween('now', '+6 months'),
            'next_calibration_date' => fake()->dateTimeBetween('+3 months', '+1 year'),
            'notes' => fake()->optional()->sentence(),
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the equipment is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Equipment::STATUS_AVAILABLE,
        ]);
    }

    /**
     * Indicate that the equipment is borrowed.
     */
    public function borrowed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Equipment::STATUS_BORROWED,
        ]);
    }

    /**
     * Indicate that the equipment is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Equipment::STATUS_MAINTENANCE,
        ]);
    }
}