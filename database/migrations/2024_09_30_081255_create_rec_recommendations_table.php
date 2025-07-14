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
        Schema::create('rec_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('recommendation_category_id')->constrained('rec_recommendation_categories')->cascadeOnDelete();
            $table->foreignId('form_id')->nullable()->constrained('mst_forms')->cascadeOnDelete();
            $table->decimal('revenue', 8, 2);
            $table->boolean('is_ward_recommendation')->default(false);
            $table->foreignId('notify_to')->nullable()->constrained('rec_recommendation_user_groups')->cascadeOnDelete();
            $table->foreignId('accepted_by')->nullable()->constrained('rec_recommendation_user_groups')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('local_body_id')->constrained('add_local_bodies')->cascadeOnDelete();
            $table->string('ward_id')->nullable();
            $table->boolean('is_ward')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_recommendations');
        Schema::dropIfExists('rec_recommendation_recommendation_user_group');
    }
};
