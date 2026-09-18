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
            $table->string('member_id')->unique();
            $table->string('name', 255);
            $table->string('photo')->nullable();
            $table->string('email', 60)->nullable();
            $table->string('phone', 20);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('plan_duration');
            $table->decimal('height', 5, 2)->nullable(); // in cm
            $table->decimal('weight', 5, 2)->nullable(); // in kg

            $table->enum('payment_method', ['credit_card', 'debit_card', 'bank_transfer', 'cash', 'other'])->nullable();
            $table->string('payment_reference')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->date('next_payment_date')->nullable();
            $table->decimal('outstanding_balance', 10, 2)->default(0);


            $table->enum('status', ['active', 'inactive', 'pending', 'suspended', 'expired', 'cancelled'])->default('pending');
            $table->date('join_date');
            $table->date('expire_date');

            $table->string('fitness_goals')->nullable();


            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();

            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('last_updated_at')->nullable();

            $table->boolean('terms_accepted')->default(false);
            $table->timestamp('terms_accepted_at')->nullable();


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
