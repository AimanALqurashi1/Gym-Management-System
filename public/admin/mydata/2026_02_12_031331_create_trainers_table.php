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
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->string('trainer_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('specialization')->nullable(); // e.g., "Yoga", "Weight Training", "Cardio"
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();

            // Employment Details
            $table->enum('employment_type', ['full_time', 'part_time', 'contract'])->default('full_time');
            $table->date('hire_date');
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->default(0); // Percentage


            // Availability
            $table->json('availability')->nullable(); // Store weekly schedule template

            // Status
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active');
            $table->text('notes')->nullable();

            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainers');
    }
};
