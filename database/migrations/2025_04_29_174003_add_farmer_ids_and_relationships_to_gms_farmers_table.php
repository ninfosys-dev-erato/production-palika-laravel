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
            $table->json('farmer_ids')->nullable()->after('user_id');
            $table->json('relationships')->nullable()->after('farmer_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_farmers', function (Blueprint $table) {
            $table->dropColumn('farmer_ids');
            $table->dropColumn('relationships');
        });
    }
};
