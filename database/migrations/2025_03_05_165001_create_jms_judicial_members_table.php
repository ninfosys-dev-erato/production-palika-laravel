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
        Schema::create('jms_judicial_members', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('member_position')->nullable(); //enum
            $table->string('elected_position')->nullable(); //enum
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_judicial_members');
    }
};
