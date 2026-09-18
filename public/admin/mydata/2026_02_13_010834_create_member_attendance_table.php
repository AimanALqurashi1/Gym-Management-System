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
        Schema::create('member_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->nullable()->constrained()->nullOnDelete();

            $table->date('attendance_date');
            $table->time('check_in_time');
            $table->time('check_out_time')->nullable();
            $table->enum('attendance_status', ['present', 'late', 'left_early', 'no_show'])->default('present');

            // Check-in method
            $table->enum('check_in_method', ['qr_code', 'rfid', 'manual', 'face_recognition', 'mobile'])->default('manual');
            $table->string('check_in_device')->nullable();

            // Duration
            $table->integer('duration_minutes')->nullable();

            $table->timestamps();

            $table->unique(['member_id', 'schedule_id', 'attendance_date'], 'unique_attendance');
            $table->index(['attendance_date', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_attendance');
    }
};
