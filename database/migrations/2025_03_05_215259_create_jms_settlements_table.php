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
        Schema::create('jms_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('discussion_date')->nullable(); // छलफल मिति
            $table->string('settlement_date')->nullable(); // मिलापत्र मिति
            $table->text('present_members')->nullable()->constraints('jms_judicial_members')->cascadeOnDelete; // उपस्थित सदस्यहरु
            $table->foreignId('reconciliation_center_id')->nullable()->constrained('jms_reconciliation_centers')->cascadeOnDelete();
            $table->text('settlement_details')->nullable(); // मिलापत्रको व्यहोरा
            $table->boolean('is_settled')->default(false); // मेलमिलाप भएको?
            $table->text('template')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_settlements');
    }
};
