<?php

use App\Models\HelpQuestion;
use App\Models\HelpQuestion\HelpQuestionCategory;
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
        Schema::create('help_question_category', function (Blueprint $table) {
            $table->foreignIdFor(HelpQuestion::class);
            $table->foreignIdFor(HelpQuestionCategory::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_question_category');
    }
};
