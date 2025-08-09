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
        Schema::create('ebps_step_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_step_id')->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->enum('role_type', ['submitter', 'approver']); // Type of role for this step
            $table->integer('position')->default(1); // Order of roles
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            
            // Ensure unique combination of step, role, and type
            $table->unique(['map_step_id', 'role_id', 'role_type'], 'unique_step_role_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_step_roles');
    }
}; 