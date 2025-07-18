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
        Schema::create('tbl_files_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('tbl_file_records')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('mst_branches')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_files_departments');
    }
};
