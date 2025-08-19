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
        Schema::create('brj_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cycle_id');
            $table->unsignedBigInteger('action_type_id');
            $table->string('status')->nullable();
            $table->text('remarks')->nullable();
            
            // User tracking fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Foreign key constraints
            $table->foreign('cycle_id')->references('id')->on('brj_resolution_cycles')->onDelete('cascade');
            $table->foreign('action_type_id')->references('id')->on('brj_action_types')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_actions');
    }
};
