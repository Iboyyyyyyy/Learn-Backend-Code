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
    Schema::create('testproducts', function (Blueprint $table) {
        $table->id('testproduct_id'); // SERIAL PRIMARY KEY
        $table->string('product_name', 255)->nullable();
        $table->unsignedBigInteger('category_id')->nullable();
        $table->timestamps();

        // Optional foreign key
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
        Schema::dropIfExists('testproducts');
    }
};
