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
        Schema::create('pln_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_type_id')->nullable()->constrained('pln_material_types')->nullOnDelete()->onUpdate('no action');
            $table->foreignId('unit_id')->nullable()->constrained('pln_units')->nullOnDelete()->onUpdate('no action');
            $table->string('title');
            $table->string('density');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_materials');
    }
};
