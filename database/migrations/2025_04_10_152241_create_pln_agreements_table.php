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
        Schema::create('pln_agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->nullable()->references('id')->on('pln_plans')->onDelete('cascade');
            $table->foreignId('consumer_committee_id')->nullable()->references('id')->on('pln_consumer_committee')->onDelete('cascade');
            $table->foreignId('implementation_method_id')->nullable()->references('id')->on('pln_implementation_methods')->onDelete('cascade');
            $table->string('plan_start_date')->nullable();
            $table->string('plan_completion_date')->nullable();
            $table->string('experience')->nullable();
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
        Schema::dropIfExists('pln_agreements');
    }
};
