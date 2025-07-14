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
        Schema::create('pln_test_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type')->nullable(); //enum (checklist,textbox,date)
            $table->boolean('is_for_agreement')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_test_lists');
    }
};
