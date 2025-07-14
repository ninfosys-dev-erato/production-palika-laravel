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
        Schema::create('gri_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grievance_assigned_to')->nullable()->constrained('users')->nullOnDelete()->onUpdate('no action');
            $table->integer('escalation_days');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_setting');
    }
};
