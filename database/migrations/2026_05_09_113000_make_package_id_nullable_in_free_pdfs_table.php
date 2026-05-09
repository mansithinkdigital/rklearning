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
        if (Schema::hasColumn('free_pdfs', 'package_id')) {
            Schema::table('free_pdfs', function (Blueprint $table) {
                $table->unsignedBigInteger('package_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('free_pdfs', 'package_id')) {
            Schema::table('free_pdfs', function (Blueprint $table) {
                $table->unsignedBigInteger('package_id')->nullable(false)->change();
            });
        }
    }
};
