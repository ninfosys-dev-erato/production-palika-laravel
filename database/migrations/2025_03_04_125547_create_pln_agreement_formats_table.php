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
        Schema::create('pln_agreement_formats', function (Blueprint $table) {
            $table->id();
            $table->string('implementation_method_id')->nullable()->constrained('pln_implementation_methods')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('sample_letter')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_agreement_formats');
    }
};
