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
        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->string('created_by', 255)
                ->nullable()
                ->comment('User ID (as string) who created the record');

            $table->string('updated_by', 255)
                ->nullable()
                ->comment('User ID (as string) who last updated the record');

            $table->string('deleted_by', 255)
                ->nullable()
                ->comment('User ID (as string) who deleted the record');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
