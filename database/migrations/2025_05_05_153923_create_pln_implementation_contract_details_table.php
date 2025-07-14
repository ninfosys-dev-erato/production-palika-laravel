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
        Schema::create('pln_implementation_contract_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('implementation_agency_id')->nullable()->constrained('pln_implementation_agencies')->cascadeOnDelete();
            $table->string('contact_number')->nullable();
            $table->string('notice_date')->nullable();
            $table->string('bid_acceptance_date')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('deposit_amount')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_implementation_contract_details');
    }
};
