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
        Schema::create('members', function (Blueprint $table) {
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



            $table->enum('status', ['active', 'inactive', 'pending', 'suspended', 'expired', 'cancelled'])->default('pending');


            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();



            /*             $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();
 */
            $table->string('code', 50)->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
