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
        Schema::create('brj_resolution_cycles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('beruju_id');
            $table->unsignedBigInteger('incharge_id');
            $table->unsignedBigInteger('assigned_by');
            $table->timestamp('assigned_at')->useCurrent();
            $table->enum('status', ['active', 'completed', 'rejected', 'inactive'])->default('active');
            $table->text('remarks')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // User tracking fields
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Foreign key constraints
            $table->foreign('beruju_id')->references('id')->on('brj_beruju_entries')->onDelete('cascade');
            $table->foreign('incharge_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('restrict');
            
            // Indexes for better performance
            $table->index(['beruju_id', 'status']);
            $table->index(['incharge_id', 'status']);
            $table->index(['assigned_at']);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brj_resolution_cycles');
    }
};
