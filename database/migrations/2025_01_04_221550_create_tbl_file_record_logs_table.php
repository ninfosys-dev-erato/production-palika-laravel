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
        Schema::create('tbl_file_record_logs', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no');
            $table->string('status')->nullable();
            $table->longText('notes');
            $table->string('handler_type');
            $table->string('handler_id');
            $table->string('receiver_type')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('sender_type')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('wards')->nullable();
            $table->string('departments')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('tbl_file_record_notifiees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_record_log_id');
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->timestamps();
            $table->foreign('file_record_log_id')->references('id')->on('tbl_file_record_logs')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_file_record_logs');
    }
};
