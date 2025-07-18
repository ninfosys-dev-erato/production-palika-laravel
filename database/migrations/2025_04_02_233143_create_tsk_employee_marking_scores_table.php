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
        Schema::create('tsk_employee_marking_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_marking_id'); // कर्मचारी मूल्याङ्कन ID
            $table->int('employee_id')->nullable;
            $table->unsignedBigInteger('criteria_id'); // Criteria reference
            $table->decimal('score_obtained', 8, 2)->default(0.00); // प्राप्त अंक (Score Obtained)
            $table->decimal('score_out_of', 8, 2); // पूर्णाङ्क (Full Marks for this Criteria)


            $table->timestamps();

            // Foreign Keys
            // $table->foreign('employee_marking_id')->references('id')->on('tsk_employee_markings')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('tsk_criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsk_employee_marking_scores');
    }
};
