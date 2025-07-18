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
        Schema::create('add_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces')->cascadeOnDelete();
            $table->string('title');
            $table->string('title_en');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_districts');
    }
};
