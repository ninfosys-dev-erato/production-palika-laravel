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
        Schema::create('pln_collection_resources', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('model');
            $table->string('collectable');
            $table->string('type'); //equipment/labour
            $table->string('quantity');
            $table->string('rate_type'); //enum: percent/flat
            $table->string('rate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_collection_resources');
    }
};
