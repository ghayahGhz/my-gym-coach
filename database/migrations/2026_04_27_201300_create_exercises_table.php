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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // bp, sq, dl …
            $table->string('name'); // Arabic exercise name
            $table->string('muscle'); // chest | back | legs | shoulder | abs | cardio | stretch
            $table->string('muscle_ar'); // Arabic muscle group
            $table->string('category'); // strength | cardio | stretch
            $table->boolean('is_time')->default(false); // reps = seconds when true
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
