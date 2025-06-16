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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->ondelete('cascade');
            $table->string('phone_number', 15)->nullable();
            $table->string('postal_code', 7)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('street', 50)->nullable();
            $table->string('apartment_number', 5)->nullable();
            $table->string('staircase_number', 5)->nullable();
            $table->date('birth_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
