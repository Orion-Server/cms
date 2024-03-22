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
        $skipSimilarMigrations = config('app.skip_similar_migrations');
        $hasColumn = fn (string $table, string $column) => Schema::hasColumn($table, $column);

        Schema::table('users', function (Blueprint $table) use ($skipSimilarMigrations, $hasColumn) {
            if (!$skipSimilarMigrations || !$hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }

            if (!$skipSimilarMigrations || !$hasColumn('users', 'referral_code')) {
                $table->string('referral_code', 15)
                    ->nullable()
                    ->unique();
            }

            $table->string('referrer_code', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'remember_token',
                'referral_code',
                'referrer_code'
            ]);
        });
    }
};
