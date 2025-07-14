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
        Schema::create('tok_token_stage_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_id')->constrained('tok_register_tokens')->cascadeOnDelete();
            $table->string('branch')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tok_token_stage_status');
    }
};
