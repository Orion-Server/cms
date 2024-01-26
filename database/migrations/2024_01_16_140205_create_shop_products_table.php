<?php

use App\Models\ShopCategory;
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
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ShopCategory::class, 'category_id');

            $table->string('name');
            $table->string('description')->nullable();
            $table->text('content')->nullable();

            $table->string('image')->nullable();
            $table->integer('price')->default(0);

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->integer('limit_per_user')->nullable();
            $table->integer('sales_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
