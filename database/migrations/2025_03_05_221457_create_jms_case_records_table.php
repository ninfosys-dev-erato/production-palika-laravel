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
        Schema::create('jms_case_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('discussion_date')->nullable(); // छलफल मिति
            $table->string('decision_date')->nullable(); // निर्णय मिति
            $table->string('decision_authority_id')->nullable()->constraints('jms_judicial_members')->cascadeOnDelete(); // निर्णय गर्ने अधिकारी
            $table->string('recording_officer_name')->nullable()->constraints('jms_judicial_employees')->cascadeOnDelete(); // अभिलेखमा राख्ने कर्मचारीको नाम
            $table->string('recording_officer_position')->nullable(); // अभिलेखमा राख्ने कर्मचारीको पद
            $table->string('remarks')->nullable(); // कैफियत
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
        Schema::dropIfExists('jms_case_records');
    }
};
