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
        Schema::create('pln_agreement_signature_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable()->references('id')->on('pln_agreements')->onDelete('cascade');
            $table->foreignId('signature_party')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('pln_agreement_signature_details');
    }
};
