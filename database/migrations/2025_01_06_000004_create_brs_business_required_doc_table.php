<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brs_business_required_doc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_registration_id')->nullable();
            $table->string('document_field')->nullable();
            $table->string('document_label_en')->nullable();
            $table->string('document_label_ne')->nullable();
            $table->string('document_filename')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('brs_businessRequiredDoc');
    }
};
