<?php

use App\Models\User;
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
        Schema::create('help_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class);

            $table->string('title');
            $table->string('slug')->index();

            $table->text('content');
            $table->boolean('visible');

            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_questions');
    }
};
