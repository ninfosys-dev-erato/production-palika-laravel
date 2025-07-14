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
        Schema::create('jms_reconciliation_centers', function (Blueprint $table) {
            $table->id();
            $table->string('reconciliation_center_title');
            $table->string('surname')->nullable();
            $table->string('title')->nullable();
            $table->string('subtile')->nullable();
            $table->string('ward_id')->nullable();
            $table->string('established_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_reconciliation_centers');
    }
};
