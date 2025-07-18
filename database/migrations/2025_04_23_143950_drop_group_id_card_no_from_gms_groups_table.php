<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gms_groups', function (Blueprint $table) {
            $table->dropColumn('group_id_card_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gms_groups', function (Blueprint $table) {
            $table->string('group_id_card_no')->unique()->nullable();
        });
    }
};