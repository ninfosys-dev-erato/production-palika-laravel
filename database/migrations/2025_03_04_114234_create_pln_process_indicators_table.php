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
        Schema::create('pln_process_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('pln_units')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_process_indicators');
    }
};
