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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('lab_id')->nullable()->after('email')->constrained('labs')->onDelete('set null');
            $table->string('phone')->nullable()->after('email_verified_at');
            $table->string('study_program')->nullable()->after('phone'); // For students
            $table->string('batch_year')->nullable()->after('study_program'); // For students (angkatan)
            $table->boolean('is_verified')->default(false)->after('batch_year'); // For student verification
            $table->boolean('is_active')->default(true)->after('is_verified');
            $table->boolean('must_change_password')->default(false)->after('is_active');
            $table->timestamp('last_login_at')->nullable()->after('must_change_password');
            
            $table->index(['lab_id', 'is_active']);
            $table->index('is_verified');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['lab_id']);
            $table->dropColumn([
                'lab_id',
                'phone',
                'study_program',
                'batch_year',
                'is_verified',
                'is_active',
                'must_change_password',
                'last_login_at'
            ]);
        });
    }
};