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
        Schema::create('rec_apply_recommendation_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apply_recommendation_id')->constrained('rec_apply_recommendations',indexName: 'recommendation_timeline')->cascadeOnDelete();
            $table->string('status_old');
            $table->string('status_new');
            $table->json('data_old')->nullable();
            $table->json('data_new')->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_apply_recommendation_timelines');
    }
};
