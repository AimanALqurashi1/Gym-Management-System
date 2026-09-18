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
        Schema::create('plan_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Access Configuration
            $table->enum('access_type', ['included', 'discounted', 'paid', 'blocked'])->default('included');

            // For included classes
            $table->integer('sessions_limit')->nullable(); // NULL = unlimited
            $table->integer('sessions_used')->default(0);
            $table->enum('period', ['day', 'week', 'month', 'year', 'lifetime'])->default('month');

            // For discounted classes
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('discounted_price', 10, 2)->nullable();

            // Priority
            $table->integer('priority')->default(0); // Higher priority = more visibility

            // Restrictions
            $table->integer('max_bookings_per_period')->nullable();
            $table->integer('min_hours_before_booking')->nullable();
            $table->integer('cancellation_hours_before')->nullable();

            // Time restrictions
            $table->json('allowed_days')->nullable(); // Days of week
            $table->json('allowed_times')->nullable(); // Time ranges



            $table->unique(['plan_id', 'course_id']);
            $table->index(['plan_id', 'access_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_course');
    }
};
