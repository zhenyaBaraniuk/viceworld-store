<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('label_product', function (Blueprint $table) {
            $table->ulid('label_id');
            $table->ulid('product_id');
            $table->integer('position');
            $table->primary(['label_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('label_product');
    }
};
