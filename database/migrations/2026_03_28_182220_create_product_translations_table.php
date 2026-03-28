<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_translations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('product_id');
            $table->string('locale');
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
    }
};
