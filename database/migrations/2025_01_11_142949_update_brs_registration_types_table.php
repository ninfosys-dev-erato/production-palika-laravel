<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brs_registration_types', function (Blueprint $table) {
            $table->foreignId(column: 'registration_category_id')->nullable()->constrained('brs_registration_categories', 'id')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('brs_registration_types', function (Blueprint $table) {
            $table->dropForeign(['registration_category_id']);
            $table->dropColumn('registration_category_id');
        });
    }
};
