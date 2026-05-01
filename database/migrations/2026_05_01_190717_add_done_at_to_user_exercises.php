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
        Schema::table('user_exercises', function (Blueprint $table) {
            $table->timestamp('done_at')->nullable()->after('done');
        });
    }

    public function down(): void
    {
        Schema::table('user_exercises', function (Blueprint $table) {
            $table->dropColumn('done_at');
        });
    }
};
