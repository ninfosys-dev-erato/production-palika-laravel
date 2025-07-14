<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete();
            $table->string('office_name')->nullable();
            $table->string('office_name_en')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_address_en')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('office_email')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('add_districts')->nullOnDelete();
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies')->nullOnDelete();
            $table->string('ward')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_settings');
    }
};
