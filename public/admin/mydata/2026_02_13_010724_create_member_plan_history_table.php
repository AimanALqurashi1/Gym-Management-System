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
        Schema::create('member_plan_history', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->foreignId('changed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('price_paid', 10, 2);
            $table->enum('change_reason', [
                'new_membership',
                'renewal',
                'upgrade',
                'downgrade',
                'cancellation',
                'expired',
                'admin_change'
            ]);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_plan_history');
    }
};
