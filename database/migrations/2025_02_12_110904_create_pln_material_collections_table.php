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
        Schema::create('pln_material_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_rate_id')->nullable()->constrained('pln_material_collections')->nullOnDelete()->onUpdate('no action');
            $table->foreignId('unit_id')->nullable()->constrained('pln_units')->nullOnDelete()->onUpdate('no action');
            $table->string('activity_no')->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete()->onUpdate('no action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_material_collections');
    }
};
