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
        Schema::create('gms_farmer_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->nullable()->constrained('gms_farmers')->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('gms_groups')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_farmer_group');
    }
};
