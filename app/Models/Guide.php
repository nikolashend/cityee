<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'slug', 'locale', 'category', 'title', 'meta_title', 'meta_description',
        'og_title', 'og_description', 'excerpt', 'content_blocks', 'faq_json',
        'ai_summary', 'key_takeaways', 'reading_time_minutes', 'author_name',
        'reviewed_by', 'city_focus', 'location_tags', 'og_image', 'priority',
        'published', 'published_at', 'related_guide_slugs', 'related_audit_slugs',
        'service_link_key',
    ];

    protected $casts = [
        'content_blocks'      => 'array',
        'faq_json'            => 'array',
        'key_takeaways'       => 'array',
        'location_tags'       => 'array',
        'related_guide_slugs' => 'array',
        'related_audit_slugs' => 'array',
        'published'           => 'boolean',
        'published_at'        => 'datetime',
        'priority'            => 'decimal:1',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get related guides (same locale, matching slugs).
     */
    public function relatedGuides()
    {
        if (empty($this->related_guide_slugs)) {
            return self::published()->locale($this->locale)
                ->where('category', $this->category)
                ->where('id', '!=', $this->id)
                ->limit(3)->get();
        }
        return self::published()->locale($this->locale)
            ->whereIn('slug', $this->related_guide_slugs)->get();
    }

    /**
     * Get related audits (same locale, matching slugs).
     */
    public function relatedAudits()
    {
        if (empty($this->related_audit_slugs)) {
            return \App\Models\AreaAudit::published()->locale($this->locale)->limit(2)->get();
        }
        return \App\Models\AreaAudit::published()->locale($this->locale)
            ->whereIn('slug', $this->related_audit_slugs)->get();
    }

    /**
     * Get the full URL path for this guide.
     */
    public function getUrlAttribute(): string
    {
        $prefix = match ($this->locale) {
            'ru' => '/ru',
            'en' => '/en',
            default => '',
        };
        return "https://cityee.ee{$prefix}/guides/{$this->slug}/";
    }

    /**
     * Service route name based on service_link_key.
     */
    public function getServiceRouteAttribute(): ?string
    {
        if (!$this->service_link_key) return null;
        return "{$this->locale}.{$this->service_link_key}";
    }
}
