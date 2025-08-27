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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique(); // Auto-generated unique identifier
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Requester
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null'); // Supervising lecturer
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->text('purpose')->nullable();
            $table->string('jsa_document_path')->nullable(); // Path to JSA PDF
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'NEEDS_REPAIR', 'CHECKED_OUT', 'RETURNED', 'OVERDUE'])->default('PENDING');
            $table->text('rejection_reason')->nullable();
            $table->text('repair_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checked_out_at')->nullable();
            $table->foreignId('checked_out_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('returned_at')->nullable();
            $table->foreignId('returned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['equipment_id', 'start_at', 'end_at']);
            $table->index('request_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};