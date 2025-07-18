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
        Schema::create('tbl_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_en')->nullable();
            $table->string('files')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_downloads');
    }
};
