<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\TaskTracking\Enums\TaskStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tms_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('tms_projects', 'id')->cascadeOnDelete();
            $table->foreignId('task_type_id')->constrained('tms_task_types', 'id')->cascadeOnDelete();
            $table->string('task_no')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default(TaskStatus::TODO->value);
            $table->nullableMorphs('assignee');
            $table->nullableMorphs('reporter');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tms_tasks');
    }
};
