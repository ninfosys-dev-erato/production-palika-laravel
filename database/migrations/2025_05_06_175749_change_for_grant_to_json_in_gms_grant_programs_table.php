<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForGrantToJsonInGmsGrantProgramsTable extends Migration
{
    public function up()
    {
        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->dropColumn('for_grant');
        });

        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->json('for_grant')->nullable();
        });
    }

    public function down()
    {
        Schema::table('gms_grant_programs', function (Blueprint $table) {
            $table->string('for_grant')->nullable()->change();
        });
    }
}
