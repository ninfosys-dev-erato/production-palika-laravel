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
        Schema::create('pln_collaterals', function (Blueprint $table) {
            $table->id();
            $table->string("plan_id")->nullable();
            $table->nullableMorphs('party');
            $table->string("deposit_type")->nullable();
            $table->string("deposit_number")->nullable();
            $table->string("contract_number")->nullable();
            $table->string("bank")->nullable();
            $table->string("issue_date")->nullable();
            $table->string("validity_period")->nullable();
            $table->string("amount")->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_collaterals');
    }
};
