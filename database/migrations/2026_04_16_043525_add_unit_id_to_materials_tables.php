<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paid_videos', function (Blueprint $table) {
            if (Schema::hasColumn('paid_videos', 'unit')) {
                $table->dropColumn('unit');
            }
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('free_pdfs', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paid_videos', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
            $table->string('unit')->nullable();
        });

        Schema::table('free_pdfs', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropColumn('unit_id');
        });
    }
};
