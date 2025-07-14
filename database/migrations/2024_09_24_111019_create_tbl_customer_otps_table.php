<?php

use App\Enums\OtpPurpose;
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
        Schema::create('tbl_customer_otps', function (Blueprint $table) {
            $table->id();
            $table->string( 'mobile_no');
            $table->enum('purpose', array_column(OtpPurpose::cases(), 'value'));
            $table->foreignId(column: 'customer_id')->nullable()->constrained('tbl_customers')->cascadeOnDelete()->nullable();
            $table->string( 'otp');
            $table->dateTime( 'validity')->default(now());
            $table->dateTime( 'verified_at')->nullable();
            $table->boolean( 'verification_flag')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_customer_otps');
    }
};