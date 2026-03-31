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
        Schema::create('orders', function (Blueprint $table) {
        $table->id('order_id'); // SERIAL PRIMARY KEY
        $table->unsignedBigInteger('customer_id')->nullable();
        $table->date('order_date')->nullable();
        $table->timestamps();

        // Foreign key (recommended)
        $table->foreign('customer_id')
              ->references('customer_id')
              ->on('customers')
              ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
