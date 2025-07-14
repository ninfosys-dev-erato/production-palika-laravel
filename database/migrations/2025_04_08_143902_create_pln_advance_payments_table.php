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
        Schema::create('pln_advance_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('pln_plans')
                ->onDelete('cascade');
            $table->string('installment')->nullable();
            $table->string('date')->nullable();
            $table->string('clearance_date')->nullable();
            $table->string('advance_deposit_number')->nullable();
            $table->string('paid_amount')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_advance_payments');
    }
};
