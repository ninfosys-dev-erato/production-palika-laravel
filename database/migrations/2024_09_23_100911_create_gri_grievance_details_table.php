<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Src\Grievance\Enums\GrievanceStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gri_grievance_details', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->foreignId('grievance_detail_id')->constrained('gri_grievance_details');
            $table->foreignId('grievance_type_id')->nullable()->constrained('gri_grievance_types');
            $table->foreignId('assigned_user_id')->constrained('users');
            $table->foreignId('customer_id')->constrained('tbl_customers');
            $table->foreignId('branch_id')->nullable()->constrained('mst_branches');
            $table->string('subject');
            $table->text('description');
            $table->string('status')->default(GrievanceStatusEnum::UNSEEN->value);
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_public')->default(true);
            $table->string('grievance_medium')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('escalation_date')->nullable();
            $table->string('priority')->nullable();
            $table->text('suggestion')->nullable();
            $table->text('investigation_type')->nullable();
            $table->text('documents')->nullable();
            $table->boolean('is_visible_to_public')->default(true);
            $table->foreignId('local_body_id')->constrained('add_local_bodies')->cascadeOnDelete();
            $table->string('ward_id')->nullable();
            $table->boolean('is_ward')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gri_grievance_details');
    }
};
