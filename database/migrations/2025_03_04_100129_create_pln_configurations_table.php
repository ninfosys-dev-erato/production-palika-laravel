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
        Schema::create('pln_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('amount')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('pln_types')->cascadeOnDelete();
            $table->boolean('use_in_cost_estimation')->default(false);
            $table->boolean('use_in_payment')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_configurations');
    }
};
