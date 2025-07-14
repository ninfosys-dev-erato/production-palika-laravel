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
        Schema::create('plan_budget_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('pln_plans')->onDelete('cascade');
            $table->foreignId('source_id');
            $table->foreignId('program');
            $table->foreignId('budget_head_id');
            $table->foreignId('expense_head_id');
            $table->foreignId('fiscal_year_id');
            $table->decimal('amount', 18, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_budget_sources');
    }
};
