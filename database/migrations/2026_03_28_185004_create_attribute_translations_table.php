<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attribute_translations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('attribute_id');
            $table->string('locale');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attribute_translations');
    }
};
