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
        Schema::create('mst_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('gender');
            $table->string('pan_no')->nullable();
            $table->boolean('is_department_head')->default(false);
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('type');
            $table->integer('ward_no')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('position')->nullable();
            $table->foreignId('branch_id')->nullable()->constrained('mst_branches')->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->constrained('mst_designations')->nullOnDelete();
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
        Schema::dropIfExists('mst_employees');
    }
};
