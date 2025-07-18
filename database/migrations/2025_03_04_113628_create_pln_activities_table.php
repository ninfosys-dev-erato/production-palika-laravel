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
        Schema::create('pln_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('group_id')->nullable()->constrained('pln_project_activity_groups')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('ref_code')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('pln_units')->onDelete('cascade');
            $table->string('qty_for')->nullable();
            $table->boolean('will_be_in_use')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_activities');
    }
};
