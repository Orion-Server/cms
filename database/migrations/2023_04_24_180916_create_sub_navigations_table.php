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
        Schema::create('sub_navigations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('navigation_id');

            $table->string('label');
            $table->string('slug')->nullable();
            $table->boolean('new_tab')->default(false);

            $table->smallInteger('order')->default(0);
            $table->boolean('visible')->default(true);

            $table->foreign('navigation_id')
                ->references('id')
                ->on('navigations')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_navigations');
    }
};
