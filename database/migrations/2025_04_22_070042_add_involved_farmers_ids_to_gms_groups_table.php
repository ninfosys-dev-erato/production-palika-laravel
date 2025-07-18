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
        Schema::table('gms_groups', function (Blueprint $table) {
            $table->json('involved_farmers_ids')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_groups', function (Blueprint $table) {
            $table->dropColumn('involved_farmers_ids');
            
        });
    }
};
