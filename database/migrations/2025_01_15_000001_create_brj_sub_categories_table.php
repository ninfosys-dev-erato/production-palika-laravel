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
        Schema::create('brj_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_eng');
            $table->string('name_nep');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_name_eng')->nullable();
            $table->string('parent_name_nep')->nullable();
            $table->string('parent_slug')->nullable();
            $table->text('remarks')->nullable();
            
            // User tracking fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key constraint for parent_id
            $table->foreign('parent_id')->references('id')->on('brj_sub_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_sub_categories');
    }
};
