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
        Schema::create('course_packages', function (Blueprint $table) {
            $table->id();
            // Foreign Keys
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('package_id');
            // Extra Fields
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->timestamps();
            // Foreign Key Constraints
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_packages');
    }
};
