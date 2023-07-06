<?php

use App\Models\Home\HomeItem;
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
        Schema::create('user_home_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);
            $table->foreignIdFor(HomeItem::class);

            $table->integer('x')->default(0);
            $table->integer('y')->default(0);
            $table->integer('z')->default(0);

            $table->boolean('placed')->default(false);
            $table->boolean('is_reversed')->default(false);

            $table->text('extra_data')->nullable();
            $table->string('theme', 15)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_home_items');
    }
};
