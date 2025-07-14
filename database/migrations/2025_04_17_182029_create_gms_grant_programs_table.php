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
        Schema::create('gms_grant_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->nullable()->references('id')->on('mst_fiscal_years')->onDelete('cascade');
            $table->foreignId('type_of_grant_id')->nullable()->references('id')->on('gms_grant_types')->onDelete('cascade');
            $table->string('program_name')->nullable();
            $table->foreignId('granting_organization_id')->nullable()->references('id')->on('gms_grant_offices')->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->references('id')->on('mst_branches')->onDelete('cascade');
            $table->string('grant_amount')->nullable();
            $table->string('for_grant')->nullable();
            $table->text('condition')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_grant_programs');
    }
};
