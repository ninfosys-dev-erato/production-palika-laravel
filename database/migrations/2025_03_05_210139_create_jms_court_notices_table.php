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
        Schema::create('jms_court_notices', function (Blueprint $table) {
            $table->id();
            $table->string('notice_no');
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('reference_no');
            $table->date('notice_date');  // तारेख मिति
            $table->time('notice_time');  // समय
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
        Schema::dropIfExists('jms_court_notices');
    }
};
