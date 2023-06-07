<?php

use App\Models\Camera;
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
        Schema::create('camera_likes', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Camera::class);
            $table->foreignIdFor(User::class);

            $table->boolean('liked')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camera_likes');
    }
};
