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
            $table->string('name', 225);
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->integer('duration')->comment('months');
            $table->enum('billing_cycle', ['quarterly', 'yearly'])->default('yearly');
            $table->integer('price');
            $table->tinyInteger('status')->default(1);
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('description', 250);
            $table->string('photo')->nullable();
            $table->enum('category', ['Mantel', 'Physical', 'Tactical'])->default('Physical');
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
