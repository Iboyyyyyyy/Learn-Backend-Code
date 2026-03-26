<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id('product_id'); // SERIAL PRIMARY KEY
        $table->string('product_name', 255)->nullable();
        $table->unsignedBigInteger('category_id')->nullable();
        $table->string('unit', 255)->nullable();
        $table->decimal('price', 10, 2)->nullable();
        $table->timestamps();

        // Foreign key (optional but recommended)
        $table->foreign('category_id')
              ->references('category_id')
              ->on('categories')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
