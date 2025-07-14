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
        Schema::create('jms_hearing_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('hearing_paper_no'); // तारेख पर्चा नं
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('hearing_date')->nullable(); // तारेख मिति
            $table->string('hearing_time')->nullable(); // समय
            $table->string('reference_no')->nullable(); // समय
            $table->text('template')->nullable();
            $table->foreignId('reconciliation_center_id')->nullable()->constrained('jms_reconciliation_centers')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_hearing_schedules');
    }
};
