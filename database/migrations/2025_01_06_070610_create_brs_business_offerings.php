<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_business_offerings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('business_offering_id')->nullable()->constrained('brs_business_offerings', 'id')->nullOnDelete()->onUpdate('no action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_business_offerings');
    }
};
