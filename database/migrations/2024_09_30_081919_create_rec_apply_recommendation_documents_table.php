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
        Schema::create('rec_apply_recommendation_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apply_recommendation_id')->constrained('rec_apply_recommendations',indexName: 'apply_recommendation_document')->cascadeOnDelete();
            $table->string('title');
            $table->string('document')->nullable();
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_apply_recommendation_documents');
    }
};
