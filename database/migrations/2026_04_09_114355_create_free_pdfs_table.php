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
        Schema::create('free_pdfs', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->unsignedBigInteger('course_id');
            $table->string('pdf_name');
            $table->string('pdf_file');
            // Foreign Key Constraints
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_pdfs');
    }
};
