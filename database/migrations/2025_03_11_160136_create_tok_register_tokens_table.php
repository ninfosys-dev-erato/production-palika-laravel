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
        Schema::create('tok_register_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('token_purpose')->nullable(); //enum
            $table->string('fiscal_year')->nullable();
            $table->string('status')->nullable(); //enum
            $table->string('date')->nullable();
            $table->string('date_en')->nullable(); 
            $table->string('branches')->nullable(); 
            $table->string('current_branch')->nullable(); 
            $table->string('stage')->nullable(); 
            $table->string('entry_time')->nullable(); 
            $table->string('exit_time')->nullable(); 
            $table->string('estimated_time')->nullable(); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tok_register_tokens');
    }
};
