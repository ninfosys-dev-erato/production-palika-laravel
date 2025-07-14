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
        Schema::create('pln_agreement_beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable()->references('id')->on('pln_agreements')->onDelete('cascade');
            $table->foreignId('beneficiary_id')->nullable()->references('id')->on('pln_benefited_members')->onDelete('cascade');
            $table->string('total_count')->nullable();
            $table->string('men_count')->nullable();
            $table->string('women_count')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_agreement_beneficiaries');
    }
};
