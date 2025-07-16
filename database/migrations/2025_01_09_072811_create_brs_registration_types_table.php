<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_registration_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('form_id')->nullable()->constrained('mst_forms')->nullOnDelete();
            $table->foreignId('registration_category_id')->nullable()->constrained('brs_registration_categories')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('mst_branches')->nullOnDelete();
            $table->string('registration_category_enum')->nullable();
            $table->string('action')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_registration_types');
    }
};
