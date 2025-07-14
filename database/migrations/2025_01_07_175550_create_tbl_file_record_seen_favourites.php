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
        Schema::create('tbl_file_record_seen_favourites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_record_id')->constrained('tbl_file_records')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->boolean('is_favourite')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_chalani')->default(false);
            $table->morphs('user');
            $table->string('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_file_record_seen_favourites');
    }
};
