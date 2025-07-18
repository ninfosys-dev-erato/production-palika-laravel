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
        Schema::create('jms_settlement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->foreignId('party_id')->constrained('jms_parties')->cascadeOnDelete();
            $table->foreignId('settlement_id')->constrained('jms_settlements')->cascadeOnDelete();
            $table->string('deadline_set_date')->nullable();
            $table->text('detail')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_settlement_details');
    }
};
