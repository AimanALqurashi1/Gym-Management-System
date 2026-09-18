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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained()->onDelete('cascade');

            // Schedule Details
            $table->enum('day_of_week', [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday'
            ]);
            $table->time('start_time');
            $table->time('end_time');

            // Recurrence (if not one-time)
            $table->enum('recurrence_type', ['weekly', 'biweekly', 'monthly', 'one_time'])->default('weekly');
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Location
            $table->string('room')->nullable();
            $table->string('location_details')->nullable();

            // Capacity for this specific schedule
            $table->integer('current_capacity')->default(0);
            $table->integer('max_capacity'); // Can override class default

            // Status
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'full'])->default('scheduled');
            $table->text('cancellation_reason')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
