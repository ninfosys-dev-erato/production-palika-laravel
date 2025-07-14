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
        Schema::create('pln_target_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('progress_indicator_id')
                ->nullable()
                ->constrained('pln_process_indicators')
                ->onDelete('cascade');

            $table->string('total_physical_progress')->nullable();
            $table->string('total_financial_progress')->nullable();
            $table->string('last_year_physical_progress')->nullable();
            $table->string('last_year_financial_progress')->nullable();
            $table->string('total_physical_goals')->nullable();
            $table->string('total_financial_goals')->nullable();
            $table->string('first_quarter_physical_progress')->nullable();
            $table->string('first_quarter_financial_progress')->nullable();
            $table->string('second_quarter_physical_progress')->nullable();
            $table->string('second_quarter_financial_progress')->nullable();
            $table->string('third_quarter_physical_progress')->nullable();
            $table->string('third_quarter_financial_progress')->nullable();

            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('pln_plans')
                ->onDelete('cascade');

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
        Schema::dropIfExists('pln_target_entries');
    }
};
