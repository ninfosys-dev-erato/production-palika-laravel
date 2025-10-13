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
        Schema::create('jms_updated_template_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_registration_id');
            $table->string('form_id');
            $table->longText('template');
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
            $table->string('deleted_by')->nullable();
            
            // Foreign key constraint
            $table->foreign('complaint_registration_id')->references('id')->on('jms_complaint_registrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_updated_template_details');
    }
};
