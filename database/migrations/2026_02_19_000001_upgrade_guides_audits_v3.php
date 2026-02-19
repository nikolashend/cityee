<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ЭТАП 5: Upgrade guides + area_audits tables with all v3 fields.
 *
 * Keeps locale-per-row model but adds:
 *   - category / audit_type
 *   - AI summary, key_takeaways, faq_json, reading_time
 *   - city_focus, location_tags, author_name, reviewed_by
 *   - og_title, og_description, inputs_schema, cta_variant
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->string('category')->default('sell')->after('locale')
                  ->comment('sell|rent|pricing|legal|marketing');
            $table->json('faq_json')->nullable()->after('content_blocks')
                  ->comment('Structured FAQ: [{q,a}, ...]');
            $table->text('ai_summary')->nullable()->after('faq_json')
                  ->comment('AI-ready short answer (3-5 bullets)');
            $table->json('key_takeaways')->nullable()->after('ai_summary')
                  ->comment('3-7 bullet takeaways');
            $table->unsignedTinyInteger('reading_time_minutes')->default(5)->after('key_takeaways');
            $table->string('author_name')->default('Aleksandr Primakov')->after('reading_time_minutes');
            $table->string('reviewed_by')->nullable()->default('CityEE OÜ')->after('author_name');
            $table->string('city_focus')->default('Tallinn')->after('reviewed_by');
            $table->json('location_tags')->nullable()->after('city_focus')
                  ->comment('["Kesklinn","Mustamäe",…]');
            $table->string('og_title')->nullable()->after('meta_description');
            $table->string('og_description')->nullable()->after('og_title');
            $table->json('related_guide_slugs')->nullable()->after('location_tags')
                  ->comment('slugs of related guides');
            $table->json('related_audit_slugs')->nullable()->after('related_guide_slugs')
                  ->comment('slugs of related audits');
            $table->string('service_link_key')->nullable()->after('related_audit_slugs')
                  ->comment('sell|rent|consultation');
        });

        Schema::table('area_audits', function (Blueprint $table) {
            $table->string('audit_type')->default('listing-audit')->after('locale')
                  ->comment('listing-audit|pricing-audit|strategy-audit|rent-audit');
            $table->json('faq_json')->nullable()->after('content_blocks')
                  ->comment('Structured FAQ: [{q,a}, ...]');
            $table->text('ai_summary')->nullable()->after('faq_json')
                  ->comment('AI-ready short answer');
            $table->json('key_takeaways')->nullable()->after('ai_summary')
                  ->comment('3-7 bullet takeaways');
            $table->unsignedTinyInteger('reading_time_minutes')->default(5)->after('key_takeaways');
            $table->string('author_name')->default('Aleksandr Primakov')->after('reading_time_minutes');
            $table->string('reviewed_by')->nullable()->default('CityEE OÜ')->after('author_name');
            $table->string('city_focus')->default('Tallinn')->after('reviewed_by');
            $table->json('location_tags')->nullable()->after('city_focus');
            $table->string('og_title')->nullable()->after('meta_description');
            $table->string('og_description')->nullable()->after('og_title');
            $table->json('inputs_schema')->nullable()->after('location_tags')
                  ->comment('What client provides: link / address / photos');
            $table->string('cta_variant')->default('audit')->after('inputs_schema')
                  ->comment('Which CTA to show: audit|calc|consultation');
            $table->json('related_guide_slugs')->nullable()->after('cta_variant');
            $table->json('related_audit_slugs')->nullable()->after('related_guide_slugs');
            $table->string('service_link_key')->nullable()->after('related_audit_slugs')
                  ->comment('sell|rent|consultation');
        });
    }

    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'faq_json', 'ai_summary', 'key_takeaways',
                'reading_time_minutes', 'author_name', 'reviewed_by',
                'city_focus', 'location_tags', 'og_title', 'og_description',
                'related_guide_slugs', 'related_audit_slugs', 'service_link_key',
            ]);
        });

        Schema::table('area_audits', function (Blueprint $table) {
            $table->dropColumn([
                'audit_type', 'faq_json', 'ai_summary', 'key_takeaways',
                'reading_time_minutes', 'author_name', 'reviewed_by',
                'city_focus', 'location_tags', 'og_title', 'og_description',
                'inputs_schema', 'cta_variant',
                'related_guide_slugs', 'related_audit_slugs', 'service_link_key',
            ]);
        });
    }
};
