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
        Schema::create('pln_project_installment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->string('installment_type');
            $table->string('date')->nullable();
            $table->double('amount', 12, 2)->default(0);
            $table->string('construction_material_quantity')->nullable();
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
        Schema::dropIfExists('pln_project_installment_details');
    }
};
