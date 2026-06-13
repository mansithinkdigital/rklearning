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
        Schema::table('course_subjects', function (Blueprint $table) {
            $table->integer('total_marks')->default(0);
            $table->integer('pass_marks')->default(0);
            $table->integer('time_limit')->default(0)->comment('In minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_subjects', function (Blueprint $table) {
            $table->dropColumn(['total_marks', 'pass_marks', 'time_limit']);
        });
    }
};
