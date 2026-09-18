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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_schedule_id')->constrained('member_schedule')->onDelete('cascade');
            $table->decimal('refund_amount', 10, 2);
            $table->decimal('refund_percentage', 5, 2);
            $table->date('refund_date');
            $table->text('cancellation_reason');
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
