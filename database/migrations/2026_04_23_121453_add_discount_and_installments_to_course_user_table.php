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
        Schema::table('course_user', function (Blueprint $table) {
            $table->decimal('discount', 10, 2)->default(0)->after('amount');
            $table->decimal('total_payable', 10, 2)->default(0)->after('discount');
            $table->decimal('paid_amount', 10, 2)->default(0)->after('total_payable');
            $table->decimal('balance_amount', 10, 2)->default(0)->after('paid_amount');
            $table->date('next_installment_date')->nullable()->after('balance_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn([
                'discount',
                'total_payable',
                'paid_amount',
                'balance_amount',
                'next_installment_date'
            ]);
        });
    }
};
