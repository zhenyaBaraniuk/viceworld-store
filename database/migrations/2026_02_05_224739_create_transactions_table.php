<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('payment_id')->index();
            $table->string('external_id')->nullable()->index();
            $table->string('provider');
            $table->string('type');
            $table->string('currency');
            $table->decimal('amount', 10);
            $table->string('status');
            $table->text('provider_response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
