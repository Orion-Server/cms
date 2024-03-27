<?php

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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'sender_id')->nullable();
            $table->foreignIdFor(User::class, 'recipient_id');

            $table->tinyInteger('type');
            $table->text('message');

            $table->string('url')->nullable();

            $table->enum('state', ['unread', 'read', 'seen'])->default('unread');
            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
