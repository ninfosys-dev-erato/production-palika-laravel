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
        Schema::create('pln_material_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->nullable()->constrained('pln_materials')->nullOnDelete()->onUpdate('no action');
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete()->onUpdate('no action');
            $table->boolean('is_vat_included')->default(0);
            $table->boolean('is_vat_needed')->default(0);
            $table->string('referance_no')->nullable();
            $table->string('royalty')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_material_rates');
    }
};
