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
        Schema::create('pln_cost_estimation_details', function (Blueprint $table) {
            $table->id();
            $table->string('cost_estimation_id')->nullable();
            $table->string('activity_group_id')->nullable();
            $table->string('activity_id')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('is_vatable')->nullable();
            $table->string('vat_amount')->nullable();
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
        Schema::dropIfExists('pln_cost_estimation_details');
    }
};
