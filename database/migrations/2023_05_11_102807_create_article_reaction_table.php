<?php

use App\Models\Article;
use App\Models\Reaction;
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
        Schema::create('article_reaction', function (Blueprint $table) {
            $table->foreignIdFor(Article::class);
            $table->foreignIdFor(Reaction::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_reaction');
    }
};
