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
        Schema::create('jms_dispute_matters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('dispute_area_id')->nullable()->constrained('jms_dispute_areas')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_dispute_matters');
    }
};
