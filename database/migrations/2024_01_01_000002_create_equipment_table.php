<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->string('name');
            $table->string('asset_code')->unique();
            $table->string('serial_number')->nullable();
            $table->string('category');
            $table->string('brand')->nullable();
            $table->text('specifications')->nullable();
            $table->string('image_url')->nullable();
            $table->json('documents')->nullable(); // Array of document objects
            $table->enum('status', ['AVAILABLE', 'BORROWED', 'BOOKED', 'MAINTENANCE', 'CALIBRATION', 'INACTIVE'])->default('AVAILABLE');
            $table->enum('risk_level', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->date('next_maintenance_date')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['lab_id', 'status']);
            $table->index('asset_code');
            $table->index('category');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};