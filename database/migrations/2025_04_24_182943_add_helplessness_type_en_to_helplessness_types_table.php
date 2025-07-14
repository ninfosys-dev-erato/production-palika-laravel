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
        Schema::table('gms_helplessness_types', function (Blueprint $table) {
            $table->string('helplessness_type_en')->nullable()->after('helplessness_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_helplessness_types', function (Blueprint $table) {
            $table->dropColumn('helplessness_type_en');
        });
    }
};
