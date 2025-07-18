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
        Schema::create('tok_token_feedbacks', function (Blueprint $table) {
            $table->unsignedBigInteger('token_id');

            $table->foreign('token_id')
                ->references('id')
                ->on('tok_register_tokens')
                ->onDelete('cascade');
            $table->longText('feedback')->nullable();
            $table->string('rating')->nullable();
            $table->string('service_quality')->nullable();
            $table->string('service_accesibility')->nullable();
            $table->string('citizen_satisfaction')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tok_token_feedbacks');
    }
};
