<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->id();
        });
    }
};
