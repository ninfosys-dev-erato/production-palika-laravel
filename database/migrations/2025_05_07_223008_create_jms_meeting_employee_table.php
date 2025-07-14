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
        Schema::create('jms_meeting_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('judicial_meeting_id')->constrained('jms_judicial_meetings')->onDelete('cascade')->nullable();
            $table->foreignId('judicial_employee_id')->constrained('jms_judicial_employees')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_meeting_employee');
    }
};
