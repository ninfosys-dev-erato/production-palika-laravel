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
        Schema::create('pln_cost_estimation', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id')->nullable();
            $table->string('date')->nullable();
            $table->string('total_cost')->nullable();
            $table->string('is_revised')->nullable();
            $table->string('revision_count')->nullable();
            $table->string('status')->nullable();
            $table->string('revision_date')->nullable();
            $table->string('rate_analysis_document')->nullable();
            $table->string('cost_estimation_document')->nullable();
            $table->string('initial_photo')->nullable();
            $table->string('document_upload')->nullable();
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
        Schema::dropIfExists('pln_cost_estimation');
    }
};
