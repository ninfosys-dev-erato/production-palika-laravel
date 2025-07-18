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
        Schema::create('jms_witnesses_representatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_registration_id')->constrained('jms_complaint_registrations')->cascadeOnDelete();
            $table->string('name')->nullable(); // साक्षी/वारेस नामाको नाम
            $table->text('address')->nullable(); // साक्षी/वारेस नामाको ठेगाना
            $table->boolean('is_first_party')->default(false); // प्रथम पक्ष हो/होइन?
            $table->text('template')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jms_witnesses_representatives');
    }
};
