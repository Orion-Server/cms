<?php

use App\Models\ShopProduct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_product_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ShopProduct::class, 'product_id');

            $table->string('name');
            $table->enum('type', ['badge', 'furniture', 'room', 'currency']);

            $table->string('data')->nullable();
            $table->integer('quantity')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_product_items');
    }
};
