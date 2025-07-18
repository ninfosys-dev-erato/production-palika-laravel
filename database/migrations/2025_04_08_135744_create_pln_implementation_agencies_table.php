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
        Schema::create('pln_implementation_agencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('consumer_committee_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->string('model')->nullable();
            $table->string('comment')->nullable();
            $table->string('agreement_application')->nullable();
            $table->string('agreement_recommendation_letter')->nullable();
            $table->string('deposit_voucher')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('pln_plans')->onDelete('cascade');
            $table->foreign('consumer_committee_id')->references('id')->on('pln_consumer_committee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_implementation_agencies');
    }
};
