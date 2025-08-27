<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Lab;
use App\Models\LoanRequest;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChemLabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create labs
        $labs = Lab::factory()->count(3)->create();

        // Create users with specific roles based on email patterns
        $admin = User::factory()->create([
            'name' => 'Administrator DTK',
            'email' => 'admin@che.ui.ac.id',
            'is_verified' => true,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $laboran = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@che.ui.ac.id',
            'lab_id' => $labs->first()->id,
            'phone' => '081234567890',
            'is_verified' => true,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $dosen = User::factory()->create([
            'name' => 'Prof. Dr. Ir. Anondho Wijanarko',
            'email' => 'anondho@che.ui.ac.id',
            'phone' => '081234567891',
            'is_verified' => true,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $mahasiswaVerified = User::factory()->create([
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@ui.ac.id',
            'phone' => '081234567892',
            'study_program' => 'Teknik Kimia',
            'batch_year' => '2021',
            'is_verified' => true,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        $mahasiswaUnverified = User::factory()->create([
            'name' => 'Sari Indah',
            'email' => 'sari.indah@ui.ac.id',
            'phone' => '081234567893',
            'study_program' => 'Teknik Kimia',
            'batch_year' => '2022',
            'is_verified' => false,
            'is_active' => true,
            'must_change_password' => false,
        ]);

        // Create equipment for each lab
        foreach ($labs as $lab) {
            Equipment::factory()
                ->count(8)
                ->for($lab)
                ->create();
        }

        // Create loan requests with different statuses
        LoanRequest::factory()
            ->pending()
            ->create([
                'user_id' => $mahasiswaVerified->id,
                'equipment_id' => Equipment::available()->first()->id,
                'supervisor_id' => $dosen->id,
            ]);

        $borrowedEquipment = Equipment::where('status', 'BORROWED')->first();
        if (!$borrowedEquipment) {
            $borrowedEquipment = Equipment::first();
            $borrowedEquipment->update(['status' => Equipment::STATUS_BORROWED]);
        }

        LoanRequest::factory()
            ->checkedOut()
            ->create([
                'user_id' => $mahasiswaVerified->id,
                'equipment_id' => $borrowedEquipment->id,
                'supervisor_id' => $dosen->id,
                'approved_by' => $laboran->id,
                'checked_out_by' => $laboran->id,
            ]);

        LoanRequest::factory()
            ->overdue()
            ->create([
                'user_id' => $mahasiswaVerified->id,
                'equipment_id' => Equipment::first()->id,
                'supervisor_id' => $dosen->id,
                'approved_by' => $laboran->id,
                'checked_out_by' => $laboran->id,
            ]);

        LoanRequest::factory()
            ->needsRepair()
            ->create([
                'user_id' => $mahasiswaVerified->id,
                'equipment_id' => Equipment::first()->id,
                'supervisor_id' => $dosen->id,
            ]);

        // Create landing page content
        Page::create([
            'key' => 'landing-hero',
            'title' => 'ChemLab Deptekim DTK FTUI',
            'content' => 'Sistem manajemen laboratorium modern untuk mengelola peminjaman dan pengembalian alat laboratorium dengan dukungan untuk berbagai peran pengguna, pelaporan, dan audit.',
            'meta' => [
                'subtitle' => 'Departemen Teknik Kimia FTUI',
                'cta_text' => 'Mulai Gunakan Sistem',
            ],
            'is_active' => true,
            'updated_by' => $admin->id,
        ]);

        Page::create([
            'key' => 'landing-contact',
            'title' => 'Kontak Laboratorium',
            'content' => 'Hubungi kami untuk bantuan dan informasi lebih lanjut',
            'meta' => [
                'email' => 'chemlab@che.ui.ac.id',
                'phone' => '(021) 7270032',
                'address' => 'Kampus UI Depok, Gedung Departemen Teknik Kimia',
                'hours' => 'Senin-Jumat 08:00-17:00',
            ],
            'is_active' => true,
            'updated_by' => $admin->id,
        ]);

        $this->command->info('✅ ChemLab demo data seeded successfully!');
        $this->command->info('');
        $this->command->info('🔐 Demo Credentials:');
        $this->command->info('Admin: admin@che.ui.ac.id / password');
        $this->command->info('Laboran: budi@che.ui.ac.id / password');
        $this->command->info('Dosen: anondho@che.ui.ac.id / password');
        $this->command->info('Mahasiswa (Verified): andi.pratama@ui.ac.id / password');
        $this->command->info('Mahasiswa (Unverified): sari.indah@ui.ac.id / password');
    }
}