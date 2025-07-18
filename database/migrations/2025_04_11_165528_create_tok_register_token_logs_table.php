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
        Schema::create('tok_register_token_logs', function (Blueprint $table) {
            $table->id();
            $table->string('token_id');

            $table->string('old_branch')->nullable();
            $table->string('current_branch')->nullable();

            $table->longText('old_stage')->nullable();
            $table->longText('current_stage')->nullable();

            $table->longText('old_status')->nullable();
            $table->longText('current_status')->nullable();

            $table->longText('old_values')->nullable();
            $table->longText('current_values')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tok_register_token_logs');
    }
};
