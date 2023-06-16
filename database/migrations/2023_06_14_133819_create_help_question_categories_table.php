<?php

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
        Schema::create('help_question_categories', function (Blueprint $table) {
            $table->id();

            $table->integer('order')->default(0);

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('icon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_question_categories');
    }
};
