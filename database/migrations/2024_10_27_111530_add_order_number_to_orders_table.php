<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_number')->after('id')->unique()->default(1);
        });

        // إضافة trigger لزيادة القيمة تلقائيًا
        DB::unprepared('
            CREATE TRIGGER tr_orders_order_number
            BEFORE INSERT ON orders
            FOR EACH ROW
            BEGIN
                SET NEW.order_number = (SELECT IFNULL(MAX(order_number), 0) + 1 FROM orders);
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
        });

        // حذف الـ trigger
        DB::unprepared('DROP TRIGGER IF EXISTS tr_orders_order_number');
    }
};
