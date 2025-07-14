<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gri_grievance_assign_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grievance_detail_id')->constrained('gri_grievance_details')->cascadeOnDelete();
            $table->foreignId('from_user_id')->constrained('users');
            $table->foreignId('to_user_id')->constrained('users');
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();
            $table->string('documents')->nullable();
            $table->string('suggestions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_grievance_assign_histories');
    }
};
