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
        Schema::create('rec_recommendation_user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('rec_recommendation_user_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recommendation_user_group_id')->constrained('rec_recommendation_user_groups','id','recommendation_group')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_recommendation_user_groups');
        Schema::dropIfExists('rec_recommendation_user_group_user');
    }
};
