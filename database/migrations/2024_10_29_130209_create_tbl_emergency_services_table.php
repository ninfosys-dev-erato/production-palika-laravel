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
        Schema::create('tbl_emergency_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_id')->nullable()->constrained('tbl_emergency_contacts')->cascadeOnDelete();
            $table->string('contact_person')->nullable(); 
            $table->string('contact_person_ne')->nullable(); 
            $table->text('address')->nullable(); 
            $table->text('address_ne')->nullable(); 
            $table->string('contact_numbers')->nullable(); 
            $table->text('site_map')->nullable(); 
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_emergency_services');
    }
};
