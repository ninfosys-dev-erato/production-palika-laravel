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
        Schema::create('jms_court_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('discussion_date')->nullable(); // छलफल मिति
            $table->string('submission_decision_date')->nullable(); // अदालत पठाउने निर्णय मिति
            $table->string('decision_authority_id')->nullable()->constraints('jms_judicial_members')->cascadeOnDelete(); // निर्णय गर्ने अधिकारी
            $table->text('template')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_court_submissions');
    }
};
