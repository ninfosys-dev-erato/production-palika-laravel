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
        Schema::create('ebps_house_owner_details', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('citizenship_no')->nullable();
            $table->string('citizenship_issued_date')->nullable();
            $table->foreignId('citizenship_issued_at')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('province_id')->nullable()->constrained('add_provinces', 'id');
            $table->foreignId('district_id')->nullable()->constrained('add_districts', 'id');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies', 'id');
            $table->string('ward_no')->nullable();
            $table->string('tole')->nullable();
        
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_house_owner_details');
    }
};
