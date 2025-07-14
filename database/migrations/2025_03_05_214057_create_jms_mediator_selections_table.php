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
        Schema::create('jms_mediator_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete(); // विवाद दर्ता नं.
            $table->foreignId('mediator_id')->constrained('jms_mediators')->cascadeOnDelete(); // मेलमिलापकर्ता
            $table->string('mediator_type')->nullable(); // मेलमिलापकर्ताको प्रकार || enum
            $table->string('selection_date')->nullable(); // मेलमिलापकर्ताको छनौट मिति
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
        Schema::dropIfExists('jms_mediator_selections');
    }
};
