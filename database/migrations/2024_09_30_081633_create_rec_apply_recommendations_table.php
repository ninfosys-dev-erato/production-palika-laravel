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
        Schema::create('rec_apply_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('tbl_customers')->cascadeOnDelete();
            $table->foreignId('recommendation_id')->constrained('rec_recommendations')->cascadeOnDelete();
            $table->json('data')->nullable();
            $table->string('status');
            $table->string('remarks')->nullable();
            $table->string('recommendation_medium')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('accepted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('accepted_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('rejected_at')->nullable();
            $table->string('rejected_reason')->nullable();
            $table->string('bill')->nullable();
            $table->string('ltax_ebp_code')->nullable();
            $table->string('additional_letter')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_year')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_apply_recommendations');
    }
};
