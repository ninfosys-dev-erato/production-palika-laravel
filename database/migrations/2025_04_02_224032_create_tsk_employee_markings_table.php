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
        // 1️⃣ Dynamic schedules (अनुसूची)
        Schema::create('tsk_anusuchis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // अनुसूची नाम (Schedule Name)
            $table->string('name_en'); // अनुसूची नाम (English)
            $table->text('description')->nullable(); // अनुसूची विवरण (Description)
            $table->timestamps();
        });

        // 2️⃣ Flexible scoring criteria
        Schema::create('tsk_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // मापदण्ड नाम (Criteria Name - Nepali)
            $table->string('name_en'); // मापदण्ड नाम (Criteria Name - English)
            $table->decimal('max_score', 8, 2); // पूर्णाङ्क (Maximum Score)
            $table->decimal('min_score', 8, 2); // न्यूनतम अंक (Minimum Score)
            $table->timestamps();
        });

        // 3️⃣ Employee scoring system
        Schema::create('tsk_employee_markings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // कर्मचारी ID
            $table->unsignedBigInteger('anusuchi_id'); // अनुसूची reference
            $table->unsignedBigInteger('criteria_id'); // Criteria reference
            $table->integer('score')->default(0); // प्राप्त अंक (Scored Points)

            $table->string('fiscal_year')->nullable(); // आर्थिक वर्ष (Fiscal Year)
            $table->string('period_title')->nullable(); // अवधि शीर्षक (Month Name in Nepali)

            // Evaluation Period
            $table->enum('period_type', ['daily', 'weekly', 'monthly'])->default('monthly');
            $table->string('date_from'); // मूल्याङ्कन सुरुवात मिति (Evaluation Start Date)
            $table->string('date_to'); // मूल्याङ्कन समाप्ति मिति (Evaluation End Date)

            $table->string('marking_batch_id'); // group employee marking



            $table->timestamps();

            // Foreign Keys
            $table->foreign('employee_id')->references('id')->on('mst_employees')->onDelete('cascade');
            $table->foreign('anusuchi_id')->references('id')->on('tsk_anusuchis')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('tsk_criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsk_employee_markings');
        Schema::dropIfExists('tsk_criteria');
        Schema::dropIfExists('tsk_anusuchis');
    }
};
