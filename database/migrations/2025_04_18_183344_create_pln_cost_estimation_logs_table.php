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
        Schema::create('pln_cost_estimation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_estimation_id')->nullable()->constrained('pln_cost_estimation')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->string('forwarded_to')->nullable();
            $table->string('remarks')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('pln_cost_estimation_logs');
    }
};
