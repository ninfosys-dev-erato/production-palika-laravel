<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ebps_filter_setting', function (Blueprint $table) {
            $table->id();
            $table->boolean('enable_role_filtering')->default(true)->comment('Enable/disable role-based filtering for this municipality');
            $table->text('description')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        // Insert default setting - role filtering enabled by default
        DB::table('ebps_filter_setting')->insert([
            'enable_role_filtering' => true,
            'description' => 'Role-based filtering enabled - Users only see applications they can work on',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebps_filter_setting');
    }
}; 