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
        Schema::create('ebps_document_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('map_apply_id')->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->string('title');
            $table->foreignId('map_document_id')->nullable()->constrained('ebps_ebps_documents')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_document_files');
    }
};
