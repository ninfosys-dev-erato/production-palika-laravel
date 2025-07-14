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
        Schema::create('pln_project_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('group_id')->nullable()->constrained('pln_project_groups')->onDelete('cascade');
            $table->string('area_id')->nullable()->constrained('pln_plan_areas')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_groups');
    }
};
