<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gms_grant_release', function (Blueprint $table) {
            $table->id();
            $table->string('grantee');
            $table->string('grantee_type');
            $table->string('investment');
            $table->boolean('is_new_or_ongoing')->default(true);
            $table->string('last_year_investment')->nullable();
            $table->string('plot_no')->nullable();
            $table->string('location')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->text('condition')->nullable();
            $table->string('grant_expenses')->nullable();
            $table->string('private_expenses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gms_grant_release');
    }
};
