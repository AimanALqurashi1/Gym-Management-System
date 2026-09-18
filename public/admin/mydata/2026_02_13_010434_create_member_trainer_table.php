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
        Schema::create('member_trainer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained()->onDelete('cascade');

            // Relationship Type
            $table->enum('assignment_type', [
                'primary',      // Main trainer
                'secondary',    // Additional trainer
                'group',        // Part of group training
                'one_on_one'    // Personal training
            ])->default('primary');

            // Assignment Details
            $table->date('assigned_at');
            $table->date('end_date')->nullable();
            $table->integer('sessions_per_week')->default(1);
            $table->decimal('session_price', 10, 2)->nullable();
            $table->decimal('trainer_commission', 5, 2)->nullable(); // % commission for this assignment

            // Progress Tracking
            $table->text('goals')->nullable();
            $table->text('achievements')->nullable();
            $table->text('notes')->nullable();

            // Schedule Preferences
            $table->json('preferred_times')->nullable(); // Preferred days/times for sessions

            // Status
            $table->enum('status', ['active', 'paused', 'completed', 'cancelled'])->default('active');
            $table->date('paused_until')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->timestamps();

            // Prevent duplicate active assignments
            $table->unique(['member_id', 'trainer_id', 'assignment_type', 'status'], 'unique_trainer_assignment');

            $table->index(['member_id', 'status']);
            $table->index(['trainer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_trainer');
    }
};
