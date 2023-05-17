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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('title');
            $table->string('description')->nullable();

            $table->text('content');

            $table->string('slug')->index();
            $table->string('image');

            $table->boolean('is_promotion')->default(false);
            $table->timestamp('promotion_ends_at')->nullable();

            $table->boolean('visible')->default(true);
            $table->boolean('fixed')->default(false);

            $table->string('predominant_color', 10)->nullable();

            $table->boolean('allow_comments')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
