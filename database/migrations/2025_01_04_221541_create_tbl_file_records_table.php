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
        Schema::create('tbl_file_records', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no');
            $table->string('title')->nullable();
            $table->string('applicant_name')->nullable();
            $table->string('applicant_address')->nullable();
            $table->string('applicant_mobile_no')->nullable();
            $table->string('recipient_department')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('recipient_position')->nullable();
            $table->string('signee_department')->nullable();
            $table->string('signee_name')->nullable();
            $table->string('signee_position')->nullable();
            $table->string('is_chalani')->default(false);
            $table->string('subject_type');
            $table->string('subject_id');
            $table->string('document_level');
            $table->integer('local_body_id');
            $table->string('sender_type');
            $table->string('sender_id');
            $table->string('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->string('ward')->nullable();
            $table->string('local_body_id')->nullable();
            $table->string('departments')->nullable();
            $table->string('sender_medium')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_file_records');
    }
};
