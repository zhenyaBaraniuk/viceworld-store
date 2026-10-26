<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['order_number']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_number')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unique('order_number');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['order_number']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unique('order_number');
        });
    }
};
