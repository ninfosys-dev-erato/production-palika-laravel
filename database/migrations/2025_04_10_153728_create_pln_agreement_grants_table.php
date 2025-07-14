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
        Schema::create('pln_agreement_grants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable()->references('id')->on('pln_agreements')->onDelete('cascade');
            $table->foreignId('source_type_id')->nullable()->references('id')->on('pln_source_types')->onDelete('cascade');
            $table->string('material_name')->nullable();
            $table->string('unit')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('pln_agreement_grants');
    }
};
