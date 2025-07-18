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
        Schema::create('met_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fiscal_year_id')->nullable()->constrained('mst_fiscal_years')->nullOnDelete();
            $table->foreignId('committee_id')->nullable()->constrained('met_committees')->nullOnDelete();
            $table->foreignId('meeting_id')->nullable()->constrained('met_meetings')->nullOnDelete();
            $table->string('meeting_name');
            $table->string('recurrence')->nullable();
            $table->string('start_date');
            $table->string('en_start_date');
            $table->string('end_date')->nullable();
            $table->string('en_end_date')->nullable();
            $table->string('recurrence_end_date')->nullable();
            $table->string('en_recurrence_end_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_print')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('met_meetings');
    }
};
