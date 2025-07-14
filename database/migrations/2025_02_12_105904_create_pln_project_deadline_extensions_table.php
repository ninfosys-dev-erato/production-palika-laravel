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
        Schema::create('pln_project_deadline_extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->string('extended_date');
            $table->string('en_extended_date')->nullable();
            $table->string('submitted_date');
            $table->string('en_submitted_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_deadline_extensions');
    }
};
