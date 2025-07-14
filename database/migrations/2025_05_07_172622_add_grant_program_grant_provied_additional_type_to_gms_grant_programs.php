<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->string('grant_provided')->nullable()->after('condition');
            $table->string('grant_provided_quantity')->nullable()->after('grant_provided');
        });
    }

    public function down(): void
    {
        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->dropColumn(['grant_provided', 'grant_provided_quantity']);
        });
    }
};
