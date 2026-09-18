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
            $table->string('name', 255);
            $table->string('photo')->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 20);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('nationality')->default('yemen');
            $table->string('address')->nullable();
            $table->decimal('height', 5, 2)->nullable(); // in cm
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->tinyInteger('status')->default(1);
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('rate')->nullable();
            $table->string('bio')->nullable();
            $table->integer('experience')->nullable()->comment('years');
            $table->string('code', 20)->unique()->nullable();

            $table->foreignId('user_id')
                ->constrained()  // References 'id' on 'users' table
                ->onDelete('cascade');

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
