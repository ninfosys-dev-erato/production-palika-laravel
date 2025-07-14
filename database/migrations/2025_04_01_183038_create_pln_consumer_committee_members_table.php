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
        Schema::create('pln_consumer_committee_members', function (Blueprint $table) {
            $table->id();
            $table->string('citizenship_number')->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('father_name')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('grandfather_name')->nullable();
            $table->string('father_in_law_name')->nullable();
            $table->string('is_monitoring_committee')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('is_account_holder')->nullable();
            $table->string('citizenship_upload')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pln_consumer_committee_members');
    }
};
