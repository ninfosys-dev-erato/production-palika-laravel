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
        Schema::table('gms_enterprises', function (Blueprint $table) {
            if (Schema::hasColumn('gms_cooperatives', 'farmer_id')) {
                $table->dropForeign(['farmer_id']);
                $table->dropColumn('farmer_id');
            }

            $table->json('involved_farmers_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gms_enterprises', function (Blueprint $table) {
            if (!Schema::hasColumn('gms_enterprises', 'farmer_id')) {
                $table->foreignId('farmer_id')->nullable()->constrained('gms_farmers')->onDelete('set null');
            }

            $table->dropColumn('involved_farmers_ids'); // or whatever new column was added
        });
    }

};
