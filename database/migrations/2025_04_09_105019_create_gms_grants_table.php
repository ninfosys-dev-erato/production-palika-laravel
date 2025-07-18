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
        Schema::create('gms_grants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->foreignId('grant_type_id')->nullable()->constrained('gms_grant_types')->cascadeOnDelete();
            $table->foreignId('grant_office_id')->nullable()->constrained('gms_grant_offices')->cascadeOnDelete();
            $table->text('grant_program_name')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('mst_branches')->cascadeOnDelete();
            $table->string('grant_amount')->default(0);
            $table->string('grant_for')->nullable();
            $table->text('main_activity')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_grants');
    }
};
