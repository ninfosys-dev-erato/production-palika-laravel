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
        Schema::create('jms_dispute_registration_courts', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('complaint_registration_id')->nullable()->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->foreignId('complaint_registration_id')->nullable()
                ->constrained('jms_complaint_registrations', 'id')
                ->cascadeOnDelete()
                ->index()
                ->foreign('complaint_registration_id', 'fk_dispute_complaint')
                ->references('id')->on('jms_complaint_registrations');
            $table->foreignId('registrar_id')->nullable()->constrained('jms_judicial_employees')->cascadeOnDelete();
            $table->foreignId('form_id')->nullable()->constrained('mst_forms')->cascadeOnDelete();
            $table->string('data')->nullable();
            $table->string('status')->nullable();
            $table->string('is_details_provided')->nullable();
            $table->string('decision_date')->nullable();
            $table->text('template')->nullable();
            $table->text('registration_indicator')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_dispute_registration_courts');
    }
};
