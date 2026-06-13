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
        Schema::create('enrollment_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollment_id');
            $table->string('receipt_no');
            $table->string('receipt_file');
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('balance_amount', 10, 2);
            $table->timestamps();

            $table->foreign('enrollment_id')->references('id')->on('course_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollment_receipts');
    }
};
