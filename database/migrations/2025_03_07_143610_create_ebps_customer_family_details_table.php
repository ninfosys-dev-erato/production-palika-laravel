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
        Schema::create('ebps_customer_family_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('tbl_customers')->cascadeOnDelete();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('grandmother_name')->nullable();
            $table->string('great_grandfather_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_customer_family_details');
    }
};
