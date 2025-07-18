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
        Schema::create('pln_work_order', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('pln_plans')
                ->onDelete('cascade');
            $table->string('plan_name')->nullable();
            $table->string('subject')->nullable();
            $table->longText('letter_body')->nullable();
            $table->longText('template')->nullable();
            $table->string('letter_sample_id')->nullable();
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
        Schema::dropIfExists('pln_work_order');
    }
};
