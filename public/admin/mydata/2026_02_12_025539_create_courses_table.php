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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_id')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Class Details
            $table->enum('category', [
                'yoga',
                'pilates',
                'zumba',
                'strength',
                'cardio',
                'hiit',
                'crossfit',
                'dance',
                'martial_arts',
                'spinning',
                'boxing',
                'aerobics',
                'meditation',
                'stretching',
                'other'
            ])->default('other');

            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced', 'all_levels'])->default('all_levels');
            $table->integer('duration_minutes')->default(60);

            // Capacity & Pricing
            $table->integer('max_capacity');
            $table->integer('min_capacity')->default(1);
            $table->decimal('price_per_session', 10, 2)->nullable(); // If class has separate pricing

            // Media
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();

            // Requirements
            $table->text('equipment_needed')->nullable();
            $table->text('attire_requirements')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_approval')->default(false);

            $table->json('meta_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
