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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Basic", "Premium", "VIP"
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2); // Monthly/plan price
            $table->string('currency')->default('USD');
            $table->enum('billing_cycle', ['quarterly', 'yearly'])->default('yearly');

            // Plan details
            $table->integer('duration_in_days'); // How many days the plan lasts
            $table->integer('max_members')->nullable(); // Max members allowed (if limited)
            $table->integer('max_trainers')->nullable(); // Max trainers per member
            $table->integer('max_classes_per_week')->nullable();

            // Features (JSON for flexibility)
            $table->json('features')->nullable(); // e.g., ["pool_access", "sauna", "personal_trainer"]

            // Access control
            $table->json('accessible_areas')->nullable(); // e.g., ["gym", "pool", "yoga_studio"]
            $table->json('accessible_hours')->nullable(); // e.g., ["peak", "off_peak", "24/7"]

            // Status & visibility
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);

            // Restrictions
            $table->integer('minimum_age')->nullable();
            $table->integer('maximum_age')->nullable();
            $table->boolean('requires_approval')->default(false);

            // Cancellation policy
            $table->integer('cancellation_notice_days')->default(0);
            $table->boolean('refundable')->default(false);
            $table->integer('refund_period_days')->nullable();

            $table->foreignId('added_by')->nullable()->constrained('users');

            // Metadata
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
        Schema::dropIfExists('plans');
    }
};
