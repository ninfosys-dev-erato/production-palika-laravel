<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_partners', function (Blueprint $table) {
            $table->id();

            $table->nullableMorphs('partners');
            $table->string('name');
            $table->string('name_en');
            $table->string('citizenship_no');
            $table->string('citizenship_issue_date');
            $table->foreignId('citizenship_issue_district_id')->nullable()->constrained('add_districts', 'id')->nullOnDelete()->onUpdate('no action');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('province_id')->nullable()->constrained('add_provinces', 'id')->nullOnDelete()->onUpdate('no action');
            $table->foreignId('district_id')->nullable()->constrained('add_districts', 'id')->nullOnDelete()->onUpdate('no action');
            $table->foreignId('local_body_id')->nullable()->constrained('add_local_bodies', 'id')->nullOnDelete()->onUpdate('no action');
            $table->string('ward_no')->nullable();
            $table->string('way')->nullable();
            $table->string('tole')->nullable();
            $table->string('house_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('national_id_card_no')->nullable();
            $table->string('gender')->nullable();
            $table->string('education_qualification')->nullable();
            $table->string('occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_back')->nullable();
            $table->integer('position');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_partners');
    }
};
