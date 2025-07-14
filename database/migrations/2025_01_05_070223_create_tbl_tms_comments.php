<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tms_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tms_tasks', 'id')->cascadeOnDelete();
            $table->text('content');
            $table->morphs('commenter');
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
        Schema::dropIfExists('tms_comments');
    }
};
