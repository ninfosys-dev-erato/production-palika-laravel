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
        Schema::create('pln_fuel_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fuel_id')->nullable()->constrained('pln_fuels')->nullOnDelete()->onUpdate('no action');
            $table->string('rate');
            $table->boolean('has_included_vat')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_fuel_rates');
    }
};
