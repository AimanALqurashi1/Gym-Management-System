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
        Schema::create('trainer_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            // Qualification Level
            $table->enum('qualification_level', ['lead', 'assistant', 'trainee', 'certified'])->default('certified');
            $table->date('certified_at')->nullable();
            $table->date('certification_expiry')->nullable();

            // Experience with this class
            $table->integer('sessions_taught')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();

            // Additional pay for this class type
            $table->decimal('additional_pay', 10, 2)->nullable();

            $table->timestamps();

            $table->unique(['trainer_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_course');
    }
};
