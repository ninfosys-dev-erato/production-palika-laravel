<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_popup_wards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('popup_id')->constrained('tbl_pop_ups', 'id')->cascadeOnDelete();
            $table->string('ward');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_popup_wards');
    }
};
