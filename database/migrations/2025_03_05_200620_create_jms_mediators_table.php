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
        Schema::create('jms_mediators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->string('listed_no')->nullable();
            $table->string('mediator_name')->nullable();
            $table->string('mediator_address')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('training_detail')->nullable();
            $table->string('mediator_phone_no')->nullable();
            $table->string('mediator_email')->nullable();
            $table->string('municipal_approval_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_mediators');
    }
};
