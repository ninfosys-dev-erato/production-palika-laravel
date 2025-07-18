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
        Schema::create('pln_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('type_id')->nullable()->constrained('pln_item_types')->cascadeOnDelete();
            $table->string('code')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('pln_units')->cascadeOnDelete();
            $table->string('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_items');
    }
};
