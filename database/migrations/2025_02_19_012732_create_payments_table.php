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
Schema::create('payment', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained('order')->onDelete('cascade');
    $table->string('payment_method'); // transfer, e-wallet, COD
    $table->string('status')->default('pending'); // pending, success, failed
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
