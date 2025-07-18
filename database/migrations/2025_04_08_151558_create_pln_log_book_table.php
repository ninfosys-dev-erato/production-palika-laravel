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
        Schema::create('pln_log_book', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('date')->nullable();
            $table->string('visit_time')->nullable();
            $table->string('return_time')->nullable();
            $table->string('visit_type')->nullable();
            $table->string('visit_purpose')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('pln_log_book');
    }
};
