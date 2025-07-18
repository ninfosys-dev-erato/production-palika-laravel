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
        Schema::create('met_committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('committee_id')->constrained('met_committees')->cascadeOnDelete();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces');
            $table->foreignId('district_id')->nullable()->constrained('add_districts');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies');
            $table->integer('ward_no')->nullable();
            $table->string('tole')->nullable();
            $table->integer('position');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('met_committee_members');
    }
};
