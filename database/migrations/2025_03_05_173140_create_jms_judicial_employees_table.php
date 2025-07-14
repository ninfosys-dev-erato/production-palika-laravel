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
        Schema::create('jms_judicial_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('local_level_id')->nullable()->constrained('jms_local_levels')->cascadeOnDelete();
            $table->string('ward_id')->nullable();
            $table->foreignId('level_id')->nullable()->constrained('jms_levels')->cascadeOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('mst_designations')->cascadeOnDelete();
            $table->string('join_date')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_judicial_employees');
    }
};
