<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop_product_items', function (Blueprint $table) {
            DB::statement("ALTER TABLE shop_product_items MODIFY COLUMN type ENUM('badge', 'furniture', 'room', 'currency', 'rank') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_product_items', function (Blueprint $table) {
            DB::statement("ALTER TABLE shop_product_items MODIFY COLUMN type ENUM('badge', 'furniture', 'room', 'currency') NOT NULL");
        });
    }
};
