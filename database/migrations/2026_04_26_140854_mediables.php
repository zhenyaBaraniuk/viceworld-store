<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mediables', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('media_id');
            $table->string('mediable_type');
            $table->ulid('mediable_id');
            $table->string('collection')->nullable();
            $table->unsignedInteger('order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mediables');
    }
};
