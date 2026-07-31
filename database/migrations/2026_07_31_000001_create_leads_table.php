<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * First-party lead registry (X999^5 §9) — ADDITIVE, SQLite-safe.
 * Stores every form submission server-side with first/last-touch attribution,
 * mail-delivery status and a duplicate fingerprint. PII is stored only as needed;
 * IP is stored hashed (HMAC), never raw. No existing table is touched.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('public_id', 40)->unique();          // ULID — safe public reference
            $table->string('form_type', 40)->index();            // callback|inquiry|audit|price_calculator

            // Contact payload (PII — never logged in plain text)
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->json('metadata_json')->nullable();           // extra per-form fields (district/type/area…)

            // Page context
            $table->string('landing_page', 500)->nullable();
            $table->string('submission_page', 500)->nullable();
            $table->string('referrer', 500)->nullable();

            // First-touch (normalized for reporting + full JSON)
            $table->string('first_touch_source', 60)->nullable()->index();
            $table->string('first_touch_medium', 60)->nullable();
            $table->string('first_touch_campaign', 120)->nullable();
            $table->string('first_touch_gclid', 200)->nullable();
            $table->json('first_touch_json')->nullable();

            // Last-touch
            $table->string('last_touch_source', 60)->nullable()->index();
            $table->string('last_touch_medium', 60)->nullable();
            $table->string('last_touch_campaign', 120)->nullable();
            $table->string('last_touch_gclid', 200)->nullable();
            $table->json('last_touch_json')->nullable();

            // Analytics linkage (non-PII)
            $table->string('ga_client_id', 100)->nullable();
            $table->string('ga_session_id', 100)->nullable();

            // Privacy / consent / dedupe
            $table->string('ip_hash', 64)->nullable();           // HMAC-SHA256, never raw IP
            $table->string('consent_state', 40)->nullable();
            $table->string('duplicate_fingerprint', 64)->index();

            // Delivery + analytics status (lead is saved regardless of these)
            $table->string('mail_status', 20)->default('pending');   // pending|sent|failed
            $table->text('mail_error')->nullable();
            $table->timestamp('mail_sent_at')->nullable();
            $table->string('analytics_status', 20)->default('unknown'); // emitted|not_emitted|failed|unknown

            $table->timestamps();
            $table->index('created_at');
            $table->index('mail_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
