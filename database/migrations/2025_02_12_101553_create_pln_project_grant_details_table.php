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
        Schema::create('pln_project_grant_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('pln_projects')->cascadeOnDelete();
            $table->string('grant_source');
            $table->string('asset_name');
            $table->double('quantity', 12, 2)->default(0);
            $table->string('asset_unit');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_project_grant_details');
    }
};
