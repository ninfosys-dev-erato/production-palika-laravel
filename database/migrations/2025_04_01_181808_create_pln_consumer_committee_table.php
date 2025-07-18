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
        Schema::create('pln_consumer_committee', function (Blueprint $table) {
            $table->id();
            $table->string('committee_type_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('formation_date')->nullable();
            $table->string('name')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('address')->nullable();
            $table->string('creating_body')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('formation_minute')->nullable();
            $table->string('number_of_attendees')->nullable();
            $table->longText('registration_certificate')->nullable();
            $table->longText('account_operation_letter')->nullable();
            $table->longText('account_closure_letter')->nullable();
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
        Schema::dropIfExists('pln_consumer_committee');
    }
};
