<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_nature_of_business', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_ne');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->string('deleted_by')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_nature_of_business');
    }
};
