<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

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
            if (!$skipSimilarMigrations || !$hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->after('password')->nullable();
            }

            if (!$skipSimilarMigrations || !$hasColumn('users', 'two_factor_recovery_codes')) {
                $table->text('two_factor_recovery_codes')->after('two_factor_secret')->nullable();
            }

            if (Fortify::confirmsTwoFactorAuthentication() && (!$skipSimilarMigrations || !$hasColumn('users', 'two_factor_confirmed_at'))) {
                $table->timestamp('two_factor_confirmed_at')->after('two_factor_recovery_codes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                'two_factor_confirmed_at',
            ] : []));
        });
    }
};
