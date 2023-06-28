<?php

use App\Models\Home\HomeCategory;
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
        Schema::create('home_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HomeCategory::class);

            $table->char('type', 1);

            $table->string('name');
            $table->string('image');
            $table->decimal('price');

            $table->string('width', 3);
            $table->string('height', 4);

            $table->boolean('enabled')->default(true);
            $table->integer('limit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_items');
    }
};
