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
        Schema::create('ebps_organization_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('ebps_organization_details')->cascadeOnDelete();
            $table->foreignId('map_apply_id')->nullable()->constrained('ebps_map_applies')->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('org_organizations')->cascadeOnDelete();
            $table->string('registration_date')->nullable();
            $table->string('name')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->text('reason_of_organization_change')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_organization_details');
    }
};
