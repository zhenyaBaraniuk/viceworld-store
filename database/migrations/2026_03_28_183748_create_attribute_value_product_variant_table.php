<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_value_product_variant', function (Blueprint $table) {
            $table->ulid('product_variant_id');
            $table->ulid('attribute_value_id');

            $table->primary(['product_variant_id', 'attribute_value_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_value_product_variant');
    }
};
