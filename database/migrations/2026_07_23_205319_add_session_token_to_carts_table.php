<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->ulid('customer_id')->nullable()->change();
            $table->string('session_token')->nullable()->after('customer_id')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->ulid('customer_id')->nullable(false)->change();
            $table->dropColumn('session_token');
        });
    }
};
