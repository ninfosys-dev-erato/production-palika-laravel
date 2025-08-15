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
        Schema::create('brj_evidences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('beruju_entry_id');
            $table->string('name');
            $table->string('evidence_document_name');
            $table->bigInteger('action_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('beruju_entry_id')->references('id')->on('brj_beruju_entries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_evidences');
    }
};
