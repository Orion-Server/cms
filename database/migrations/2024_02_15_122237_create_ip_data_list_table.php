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
        Schema::create('ip_data_list', function (Blueprint $table) {
            $table->id();

            $table->string('ip');
            $table->enum('ip_condition', ['whitelist', 'blacklist']);
            $table->string('asn')->nullable();
            $table->enum('asn_condition', ['whitelist', 'blacklist']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_data_list');
    }
};
