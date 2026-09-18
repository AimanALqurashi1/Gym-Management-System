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
        Schema::create('equipment_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['routine', 'repair', 'inspection', 'cleaning'])->default('routine');
            $table->date('maintenance_date');
            $table->date('next_maintenance_date')->nullable();
            $table->text('description');
            $table->text('notes')->nullable();
            $table->string('performed_by')->nullable(); // Name of technician
            $table->decimal('cost', 10, 2)->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->json('parts_replaced')->nullable(); // Store parts replaced
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->boolean('requires_followup')->default(false);
            $table->text('followup_notes')->nullable();
            $table->json('attachments')->nullable(); // For storing images/documents
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index('equipment_id');
            $table->index('maintenance_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};
