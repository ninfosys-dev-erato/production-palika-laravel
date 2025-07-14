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
        Schema::create('pln_evaluation_cost_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('pln_evaluations');
            $table->string("activity_id");
            $table->string("unit");
            $table->string("agreement");
            $table->string("before_this");
            $table->string("up_to_date_amount");
            $table->string("current");
            $table->string("rate");
            $table->string("assessment_amount");
            $table->string("vat_amount");
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
        Schema::dropIfExists('pln_evaluation_cost_details');
    }
};
