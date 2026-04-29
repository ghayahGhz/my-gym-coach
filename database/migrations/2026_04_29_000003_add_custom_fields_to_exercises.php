<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->boolean('is_custom')->default(false)->after('youtube_url');
            $table->unsignedBigInteger('user_profile_id')->nullable()->after('is_custom');
            $table->foreign('user_profile_id')->references('id')->on('user_profiles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropForeign(['user_profile_id']);
            $table->dropColumn(['is_custom', 'user_profile_id']);
        });
    }
};
