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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('category_id')->constrained('equipment_categories');
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('current_value', 10, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('warranty_until')->nullable();
            $table->string('location')->nullable(); // e.g., "Main Gym", "Studio 1"
            $table->enum('status', ['available', 'in_use', 'maintenance', 'broken', 'retired'])->default('available');
            $table->integer('quantity')->default(1);
            $table->integer('available_quantity')->default(1);
            $table->string('image')->nullable();
            $table->text('notes')->nullable();
            $table->json('specifications')->nullable(); // For storing technical specs
            $table->json('maintenance_schedule')->nullable(); // For storing maintenance intervals
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->boolean('needs_maintenance')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes(); // For archiving retired equipment

            // Indexes for better performance
            $table->index('status');
            $table->index('category_id');
            $table->index('next_maintenance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
