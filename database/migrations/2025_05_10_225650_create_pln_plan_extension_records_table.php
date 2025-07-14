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
        Schema::create('pln_plan_extension_records', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->timestamp('extension_date')->nullable();
            $table->timestamp('previous_extension_date')->nullable();
            $table->timestamp('previous_completion_date')->nullable();
            $table->timestamp('letter_submission_date')->nullable();
            $table->string('letter')->nullable();
            $table->string("vat_amount");
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_plan_extension_records');
    }
};
