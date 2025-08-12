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
        Schema::create('brj_beruju_entries', function (Blueprint $table) {
            $table->id();

            // Form fields from form.blade.php
            $table->string('fiscal_year_id')->nullable();
            $table->string('audit_type')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('project_id')->nullable();
            $table->string('beruju_category')->nullable();
            $table->string('sub_category_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency_type')->nullable();
            $table->text('legal_provision')->nullable();
            $table->string('action_deadline')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();

            // Additional fields
            $table->string('status')->default('draft');
            $table->string('submission_status')->default('draft');

            // User tracking fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_beruju_entries');
    }
};
