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
        Schema::create('tms_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tms_tasks')->onDelete('cascade'); 
            $table->string('action')->nullable();
            $table->morphs('user');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_activites');
    }
};
