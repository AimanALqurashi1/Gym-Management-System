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
        Schema::create('member_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');

            $table->date('enrolled_date');
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->foreignId('added_by')->nullable()->constrained('users')->after('status');

            // Payment related columns
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'overdue', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->decimal('amount_due', 10, 2)->nullable();
            $table->date('last_payment_date')->nullable();
            $table->date('payment_due_date')->nullable();

            // Cancellation related columns
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users');

            // Refund related
            $table->decimal('refund_amount', 10, 2)->default(0);
            $table->date('refund_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_schedule');
    }
};
