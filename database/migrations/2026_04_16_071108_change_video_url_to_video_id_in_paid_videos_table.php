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
        Schema::table('paid_videos', function (Blueprint $table) {
            $table->renameColumn('video_url', 'video_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paid_videos', function (Blueprint $table) {
            $table->renameColumn('video_id', 'video_url');
        });
    }
};
