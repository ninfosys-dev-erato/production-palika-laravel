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
        Schema::create('grievance_details_investigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grievance_detail_id')
                ->constrained('gri_grievance_details', 'id')
                ->cascadeOnDelete()
                ;
                
            $table->foreignId('grievance_investigation_type_id')
                ->constrained('gri_grievance_investigation_types', 'id')
                ->cascadeOnDelete()
                ;
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grievance_details_investigation_types');
    }
};
