<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_business_registration_templates', function (Blueprint $table) {
            $table->id();
            $table->string('for');
            $table->string('title');
            $table->longText('data');
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_business_registration_templates');
    }
};
