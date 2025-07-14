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
        Schema::create('pln_consumer_committee_officials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consumer_committee_id')->constrained('pln_consumer_committees')->cascadeOnDelete();
            $table->string('post');
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_consumer_committee_officials');
    }
};
