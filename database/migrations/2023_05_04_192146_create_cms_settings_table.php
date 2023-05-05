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
        Schema::create('cms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50)->unique();
            $table->string('value')->nullable();
            $table->string('comment')->nullable()->comment('Explain this setting here');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_settings');
    }
};
