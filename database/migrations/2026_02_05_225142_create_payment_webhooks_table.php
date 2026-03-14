<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_webhooks', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('payment_id')->nullable()->index();
            $table->ulid('transaction_id')->nullable()->index();
            $table->string('provider');
            $table->string('type')->nullable();
            $table->string('status');
            $table->text('headers');
            $table->text('payload');
            $table->boolean('is_valid');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_webhooks');
    }
};
