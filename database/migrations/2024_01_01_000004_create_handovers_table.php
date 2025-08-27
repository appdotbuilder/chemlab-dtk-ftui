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
        Schema::create('handovers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_request_id')->constrained('loan_requests')->onDelete('cascade');
            $table->enum('type', ['CHECK_OUT', 'CHECK_IN']);
            $table->foreignId('handled_by')->constrained('users')->onDelete('cascade'); // Lab technician
            $table->json('condition_photos')->nullable(); // Array of photo URLs
            $table->json('accessory_checklist')->nullable(); // JSON checklist of accessories
            $table->text('notes')->nullable();
            $table->text('damage_report')->nullable(); // For check-in, any damages found
            $table->string('qr_code_path')->nullable(); // Path to generated QR code for borrowing receipt
            $table->timestamps();
            
            $table->index(['loan_request_id', 'type']);
            $table->index('handled_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handovers');
    }
};