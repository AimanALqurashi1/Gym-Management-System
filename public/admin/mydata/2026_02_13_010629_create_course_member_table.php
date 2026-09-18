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
        Schema::create('course_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained()->onDelete('set null');

            // Booking Details
            $table->enum('booking_status', [
                'booked',
                'attended',
                'no_show',
                'cancelled',
                'waitlisted',
                'rescheduled'
            ])->default('booked');

            $table->date('booking_date');
            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();

            // Waitlist
            $table->integer('waitlist_position')->nullable();
            $table->timestamp('waitlist_notified_at')->nullable();

            // Payment
            $table->decimal('price_paid', 10, 2)->nullable();
            $table->enum('payment_status', ['paid', 'pending', 'refunded', 'free'])->default('pending');
            $table->string('payment_reference')->nullable();

            // How they booked
            $table->enum('booking_source', ['web', 'mobile', 'reception', 'trainer'])->default('web');

            // Feedback
            $table->integer('rating')->nullable();
            $table->text('feedback')->nullable();
            $table->text('trainer_feedback')->nullable();

            // Cancellation
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();

            // Prevent double booking
            $table->unique(['member_id', 'schedule_id', 'booking_date'], 'unique_booking');

            $table->index(['schedule_id', 'booking_status']);
            $table->index(['member_id', 'booking_date']);
            $table->index(['course_id', 'booking_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_member');
    }
};
