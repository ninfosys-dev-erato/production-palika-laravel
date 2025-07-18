<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_citizen_charter_wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_charter_id')->constrained('tbl_citizen_charters', 'id')->cascadeOnDelete();
            $table->string('ward');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_citizen_charter_wards');
    }
};
