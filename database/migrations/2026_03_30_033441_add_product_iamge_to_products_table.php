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
    Schema::table('products', function (Blueprint $table) {
        // Renamed to 'images' to match your intent
        $table->string('images', 255)->after('unit')->nullable();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        // Match the name used in the up() method
        $table->dropColumn('images');
    });
}
};
