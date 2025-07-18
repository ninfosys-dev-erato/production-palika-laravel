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
        Schema::create('org_organization_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('photo', 2048)->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_organization')->default(1);
            $table->foreignId('organization_id')->constrained('org_organizations', 'id')->cascadeOnDelete();
            $table->boolean('can_work')->default(0);
            $table->string('status')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_organization_users');
    }
};
