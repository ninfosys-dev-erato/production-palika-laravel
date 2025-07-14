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
        Schema::create('tbl_emergency_contacts', function (Blueprint $table) {
            $table->id(); 
            $table->string('group'); // <- New column for grouping like temple, hospital, etc.
            $table->string('service_name'); 
            $table->string('service_name_ne'); 
            $table->string('icon')->nullable(); 
            $table->string('contact_person')->nullable(); 
            $table->string('contact_person_ne')->nullable(); 
            $table->text('address')->nullable(); 
            $table->text('address_ne')->nullable(); 
            $table->string('contact_numbers')->nullable(); 
            $table->text('site_map')->nullable(); 
            $table->text('website_url')->nullable(); 
            $table->text('facebook_url')->nullable(); 
            $table->text('content')->nullable(); 
            $table->text('content_ne')->nullable(); 
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_emergency_contacts');
    }
};
