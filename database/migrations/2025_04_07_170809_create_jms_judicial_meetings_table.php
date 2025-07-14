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
        Schema::create('jms_judicial_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->constrained('mst_fiscal_years')->onDelete('cascade');
            $table->string('meeting_date')->nullable();
            $table->string('meeting_time')->nullable();
            $table->string('meeting_number')->unique()->nullable();
            $table->string('decision_number')->nullable();
            $table->foreignId('invited_employee_id')->constrained('jms_judicial_members')->onDelete('cascade')->nullable();
            $table->foreignId('members_present_id')->constrained('jms_judicial_members')->onDelete('cascade')->nullable();
            $table->text('meeting_topic')->nullable();
            $table->text('decision_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_judicial_meetings');
    }
};
