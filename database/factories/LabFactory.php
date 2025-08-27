<?php

namespace Database\Factories;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lab>
 */
class LabFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Lab>
     */
    protected $model = Lab::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $labs = [
            [
                'name' => 'Laboratorium Operasi Teknik Kimia (OTK)',
                'description' => 'Lab untuk praktikum operasi teknik kimia, distilasi, absorpsi, dan ekstraksi',
                'location' => 'Gedung Departemen Teknik Kimia Lt. 2',
                'capacity' => 40,
                'head_name' => 'Prof. Dr. Ir. Anondho Wijanarko, M.Eng.',
                'technician_name' => 'Budi Santoso, S.T.',
                'contact_email' => 'otk@che.ui.ac.id',
                'contact_phone' => '(021) 7270032 ext. 201',
                'rules' => 'Wajib menggunakan APD lengkap, dilarang makan/minum di lab, upload JSA sebelum praktikum',
            ],
            [
                'name' => 'Laboratorium Kimia Analitik',
                'description' => 'Lab untuk analisis instrumental, spektroskopi, dan kromatografi',
                'location' => 'Gedung Departemen Teknik Kimia Lt. 1',
                'capacity' => 30,
                'head_name' => 'Dr. Ir. Sari Edi Cahyaningrum, M.T.',
                'technician_name' => 'Siti Aminah, S.Si.',
                'contact_email' => 'analitik@che.ui.ac.id',
                'contact_phone' => '(021) 7270032 ext. 202',
                'rules' => 'Wajib kalibrasi alat sebelum digunakan, bersihkan alat setelah pemakaian',
            ],
            [
                'name' => 'Laboratorium Proses Industri',
                'description' => 'Lab untuk simulasi proses industri, reaktor, dan sistem kontrol',
                'location' => 'Gedung Departemen Teknik Kimia Lt. 3',
                'capacity' => 35,
                'head_name' => 'Prof. Dr. Ir. Mahmud Sudibandriyo, M.T.',
                'technician_name' => 'Agus Priyanto, S.T.',
                'contact_email' => 'proses@che.ui.ac.id',
                'contact_phone' => '(021) 7270032 ext. 203',
                'rules' => 'Periksa sistem keselamatan sebelum operasi, laporkan anomali segera',
            ],
        ];

        static $index = 0;
        $lab = $labs[$index % count($labs)];
        $index++;

        return array_merge($lab, [
            'operating_hours' => [
                'monday' => '08:00-17:00',
                'tuesday' => '08:00-17:00',
                'wednesday' => '08:00-17:00',
                'thursday' => '08:00-17:00',
                'friday' => '08:00-17:00',
                'saturday' => 'Closed',
                'sunday' => 'Closed',
            ],
            'gallery' => [
                'https://via.placeholder.com/800x600/2563eb/ffffff?text=Lab+Equipment',
                'https://via.placeholder.com/800x600/059669/ffffff?text=Lab+Interior',
            ],
            'documents' => [
                [
                    'name' => 'SOP Keselamatan Laboratorium',
                    'url' => '/documents/sop-safety.pdf',
                    'type' => 'PDF'
                ],
                [
                    'name' => 'Panduan Penggunaan Alat',
                    'url' => '/documents/equipment-guide.pdf',
                    'type' => 'PDF'
                ]
            ],
            'is_active' => true,
        ]);
    }
}