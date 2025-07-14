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
        Schema::table('gms_farmers', function (Blueprint $table) {
            // Drop the existing unique constraint on the unique_id column
            $table->dropUnique(['unique_id']);
        });

        Schema::table('gms_farmers', function (Blueprint $table) {
            // Make the unique_id nullable
            $table->string('unique_id')->nullable()->change();

            // Add the unique constraint back
            $table->unique('unique_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_farmers', function (Blueprint $table) {
            // Drop the unique constraint before modifying the column
            $table->dropUnique(['unique_id']);

            // Now modify the column to make it nullable
            $table->string('unique_id')->nullable()->change();
        });
    }
};
