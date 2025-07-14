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
        Schema::create('pln_project_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->string('document_name');
            $table->longText('data');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_documents');
    }
};
