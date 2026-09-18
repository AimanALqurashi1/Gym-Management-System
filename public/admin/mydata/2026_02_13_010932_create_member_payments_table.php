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
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('amount', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);

            $table->enum('payment_type', [
                'membership_fee',
                'class_booking',
                'personal_training',
                'product',
                'late_fee',
                'registration_fee',
                'other'
            ]);

            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'bank_transfer', 'mobile_money', 'other']);
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');

            $table->date('payment_date');
            $table->date('due_date')->nullable();

            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index(['member_id', 'payment_date']);
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_payments');
    }
};
