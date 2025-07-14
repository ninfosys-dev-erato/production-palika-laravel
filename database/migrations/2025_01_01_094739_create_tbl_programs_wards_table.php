<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_programs_wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('tbl_programs')->cascadeOnDelete();
            $table->string('ward');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_programs_wards');
    }
};