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
        Schema::create('member_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('category', [
                'weight_loss',
                'muscle_gain',
                'endurance',
                'strength',
                'flexibility',
                'general_fitness',
                'sports_performance',
                'other'
            ]);

            $table->decimal('target_value', 8, 2)->nullable();
            $table->decimal('current_value', 8, 2)->nullable();
            $table->string('unit')->nullable(); // kg, lbs, cm, inches, etc.

            $table->date('start_date');
            $table->date('target_date')->nullable();
            $table->date('achieved_date')->nullable();

            $table->enum('status', ['not_started', 'in_progress', 'achieved', 'abandoned'])->default('not_started');

            $table->integer('progress_percentage')->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['member_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_goals');
    }
};
