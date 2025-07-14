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
        Schema::create('tok_branch_register_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_token_id')->constrained('tok_register_tokens')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('mst_branches')->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tok_branch_register_tokens');
    }
};
