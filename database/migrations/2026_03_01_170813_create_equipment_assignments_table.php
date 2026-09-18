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
        Schema::create('equipment_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->morphs('assignable'); // Can be assigned to Member, Trainer, Class
            $table->integer('quantity')->default(1);
            $table->dateTime('assigned_at');
            $table->dateTime('expected_return_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->enum('status', ['assigned', 'returned', 'overdue'])->default('assigned');
            $table->text('purpose')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users');
            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index(['equipment_id', 'status']);
            $table->index('expected_return_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_assignments');
    }
};
