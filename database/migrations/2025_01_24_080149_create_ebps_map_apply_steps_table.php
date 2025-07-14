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
        Schema::create('ebps_map_apply_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_id')->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->foreignId('form_id')->constrained('mst_forms')->cascadeOnDelete();
            $table->foreignId('map_step_id')->constrained('ebps_map_steps')->cascadeOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->longText('template')->nullable();
            $table->string('status')->default('pending');
            $table->string('reason')->nullable();
            $table->timestamp('sent_to_approver_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_apply_steps');
    }
};
