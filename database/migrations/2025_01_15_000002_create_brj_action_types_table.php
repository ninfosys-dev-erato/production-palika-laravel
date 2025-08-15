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
        Schema::create('brj_action_types', function (Blueprint $table) {
            $table->id();
            $table->string('name_eng', 255);
            $table->string('name_nep', 255);
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('sub_category_id')
                  ->references('id')
                  ->on('brj_sub_categories')
                  ->onDelete('set null');

            // Indexes for better performance
            $table->index('sub_category_id');
            $table->index('form_id');

            // User tracking fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_action_types');
    }
};
