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
        Schema::create('ebps_map_important_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ebps_document_id')->nullable()->constrained('ebps_ebps_documents')->cascadeOnDelete();
            $table->boolean('can_be_null')->default(false)->nullable();
            $table->json('map_important_document_type')->nullable();
            $table->string('accepted_file_type')->nullable();
            $table->boolean('needs_approval')->default(false)->nullable();
            $table->string('position')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_map_important_documents');
    }
};
