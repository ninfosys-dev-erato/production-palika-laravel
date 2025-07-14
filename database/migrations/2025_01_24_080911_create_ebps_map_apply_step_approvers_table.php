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
        Schema::create('ebps_map_apply_step_approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_step_id')->constrained('ebps_map_apply_steps');
            $table->foreignId('map_pass_group_id')->constrained('ebps_map_pass_groups');
            $table->foreignId('user_id')->constrained('users');
            $table->string('status')->nullable();
            $table->text('reason')->nullable();
            $table->string('type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_apply_step_approvers');
    }
};
