<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add an is_test flag (X999^5 §8B/§21) so a synthetic/test click-id can never be
 * counted as a real Google Ads conversion. Additive; SQLite-safe.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->boolean('is_test')->default(false)->index()->after('duplicate_fingerprint');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('is_test');
        });
    }
};
