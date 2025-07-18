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
        Schema::create('add_local_bodies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->nullable()->constrained('add_districts')->cascadeOnDelete();
            $table->string('title');
            $table->string('title_en');
            $table->integer('wards')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_local_bodies');
    }
};
