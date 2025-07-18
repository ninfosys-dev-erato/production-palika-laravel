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
        Schema::create('pln_plan_templates', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('template_for')->nullable();
            $table->string('title');
            $table->longText('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_plan_templates');
    }
};
