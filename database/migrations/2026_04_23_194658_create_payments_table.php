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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Relationships
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('schedule_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('member_schedule_id')->nullable()->constrained('member_schedule')->onDelete('set null');

            // Payment details
            $table->string('receipt_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['cash'])->default('cash');

            // Period covered
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();

            // Status
            $table->enum('status', ['paid', 'refunded', 'partial_refund'])->default('paid');

            // Additional info
            $table->string('receipt_image')->nullable();
            $table->text('notes')->nullable();

            // Audit
            $table->foreignId('recorded_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('member_id');
            $table->index('payment_date');
            $table->index('status');
            $table->index('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
