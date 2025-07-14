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
        Schema::create('pln_benefited_member_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->integer('ward_no');
            $table->string('village');
            $table->integer('dalit_backward_no')->nullable();
            $table->integer('other_households_no')->nullable();
            $table->integer('no_of_male')->nullable();
            $table->integer('no_of_female')->nullable();
            $table->integer('no_of_others')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_benefited_member_details');
    }
};
