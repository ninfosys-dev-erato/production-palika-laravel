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
        Schema::create('jms_judicial_committees', function (Blueprint $table) {
            $table->id();
            $table->string('ommittees_title')->nullable();
            $table->string('short_title')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('formation_date')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_judicial_committees');
    }
};
