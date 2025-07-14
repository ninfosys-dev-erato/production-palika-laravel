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
        Schema::create('gms_grant_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grant_id')->nullable()->constrained('gms_grants')->cascadeOnDelete();
            $table->string('grant_for')->nullable();
            $table->nullableMorphs('model');
            $table->double('personal_investment', 12, 2)->default(0);
            $table->boolean('is_old')->default(0);
            $table->foreignId('prev_fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->cascadeOnDelete();
            $table->double('investment_amount', 12, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies')->cascadeOnDelete();
            $table->integer('ward_no')->nullable();
            $table->string('village')->nullable();
            $table->string('tole')->nullable();
            $table->string('plot_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_grant_details');
    }
};
