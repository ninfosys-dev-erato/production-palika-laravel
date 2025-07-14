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
        Schema::table('rec_recommendations', function (Blueprint $table) {
            $table->foreignId('accepted_by')
                ->nullable()
                ->constrained('rec_recommendation_user_groups')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rec_recommendations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('accepted_by');
        });
    }
};
