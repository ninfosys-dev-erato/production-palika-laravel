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
        Schema::create('pln_project_bid_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->string('submission_type');
            $table->string('submission_no');
            $table->string('date');
            $table->double('amount', 12, 2)->default(0);
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_bid_submissions');
    }
};
