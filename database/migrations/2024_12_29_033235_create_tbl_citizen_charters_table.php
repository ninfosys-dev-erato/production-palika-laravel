<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_citizen_charters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('mst_branches')->nullOnDelete();
            $table->string('service');
            $table->text('required_document');
            $table->string('amount');
            $table->string('time');
            $table->string('responsible_person');
            $table->boolean('can_show_on_admin')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_citizen_charters');
    }
};
