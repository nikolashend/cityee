<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('locale', 5)->default('et')->index(); // et, ru, en
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('excerpt')->nullable();
            $table->json('content_blocks'); // Structured JSON: intro, sections, faq, cta
            $table->string('og_image')->nullable();
            $table->decimal('priority', 2, 1)->default(0.7);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['slug', 'locale']);
        });

        Schema::create('area_audits', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('locale', 5)->default('et')->index();
            $table->string('title');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('excerpt')->nullable();
            $table->json('content_blocks'); // Structured JSON: summary, market_data, strategy, faq
            $table->string('og_image')->nullable();
            $table->decimal('priority', 2, 1)->default(0.7);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['slug', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_audits');
        Schema::dropIfExists('guides');
    }
};
