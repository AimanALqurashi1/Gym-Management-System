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
        Schema::create('class_instance_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_instance_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->enum('attendance_status', ['present', 'absent', 'late'])->nullable();

            $table->time('check_in_time')->nullable();
            $table->time('check_out_time')->nullable();

            $table->integer('duration_minutes')->nullable();
            $table->string('note', 225)->nullable();
            $table->foreignId('marked_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_instance_member');
    }
};
