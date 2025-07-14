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
        Schema::table('gms_farmers', function (Blueprint $table) {
            $table->json('involved_enterprise_ids')->nullable()->after('involved_group_ids');
            $table->json('involved_cooperative_ids')->nullable()->after('involved_enterprise_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_farmers', function (Blueprint $table) {
            $table->dropColumn(['involved_enterprise_ids', 'involved_cooperative_ids']);
        });
    }
};
