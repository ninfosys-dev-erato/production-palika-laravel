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
        Schema::create('pln_agreement_cost_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_cost_id')->nullable()->constrained('pln_agreement_cost')->onDelete('cascade');
            $table->foreignId('cost_estimation_details_id')->nullable()->constrained('pln_cost_estimation_details')->onDelete('cascade');
            $table->string('activity_id')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('estimated_rate')->nullable();
            $table->string('contractor_rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('vat_amount')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('pln_agreement_cost_details');
    }
};
