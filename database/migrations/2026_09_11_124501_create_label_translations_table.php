<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('label_translations', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('label_id');
            $table->string('locale');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('label_translations');
    }
};
