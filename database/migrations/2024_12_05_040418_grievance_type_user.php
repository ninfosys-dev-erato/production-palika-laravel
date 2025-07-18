<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("grievance_type_user", function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('grievance_type_id')->constrained('gri_grievance_types')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grievance_type_user');
    }
};
