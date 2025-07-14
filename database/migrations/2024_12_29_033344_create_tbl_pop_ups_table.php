<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_pop_ups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('photo');
            $table->boolean('is_active')->default(true);
            $table->integer('display_duration')->default(5);
            $table->integer('iteration_duration')->default(20);
            $table->boolean('can_show_on_admin')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_pop_ups');
    }
};
