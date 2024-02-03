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
        Schema::create('cms_writeable_boxes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('description')->nullable();
            $table->enum('page_target', ['staff', 'shop', 'teams']);

            $table->text('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_writeable_boxes');
    }
};
