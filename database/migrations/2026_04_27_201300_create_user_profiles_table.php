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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender')->default('female'); // male | female
            $table->decimal('weight', 5, 1)->default(70.0); // kg
            $table->decimal('height', 5, 1)->default(170.0); // cm
            $table->integer('session_dur')->default(90); // 60 | 90 | 120 minutes
            $table->integer('rest_dur')->default(90); // 15–300 seconds
            $table->json('days')->default('["sat","tue","thu"]'); // training days
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
