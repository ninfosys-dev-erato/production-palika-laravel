<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_registered_business', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_detail_id')->nullable()->constrained('brs_applied_business_detail', 'id')->nullOnDelete()->onUpdate('no action');
            $table->string('registration_no')->nullable();
            $table->string('business_name')->nullable();
            $table->string('registration_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_registered_business');
    }
};
