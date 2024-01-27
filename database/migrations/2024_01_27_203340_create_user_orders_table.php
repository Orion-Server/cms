<?php

use App\Models\ShopProduct;
use App\Models\User;
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
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(ShopProduct::class, 'product_id');

            $table->string('order_id');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');

            $table->integer('price');
            $table->string('currency')->nullable();

            $table->string('paypal_fee')->nullable();

            $table->text('details')->nullable();
            $table->boolean('is_delivered')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_orders');
    }
};
