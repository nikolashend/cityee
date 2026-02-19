<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaAudit extends Model
{
    protected $fillable = [
        'slug', 'locale', 'audit_type', 'title', 'meta_title', 'meta_description',
        'og_title', 'og_description', 'excerpt', 'content_blocks', 'faq_json',
        'ai_summary', 'key_takeaways', 'reading_time_minutes', 'author_name',
        'reviewed_by', 'city_focus', 'location_tags', 'og_image', 'priority',
        'published', 'published_at', 'inputs_schema', 'cta_variant',
        'related_guide_slugs', 'related_audit_slugs', 'service_link_key',
    ];

    protected $casts = [
        'content_blocks'      => 'array',
        'faq_json'            => 'array',
        'key_takeaways'       => 'array',
        'location_tags'       => 'array',
        'inputs_schema'       => 'array',
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

    public function scopeAuditType($query, string $type)
    {
        return $query->where('audit_type', $type);
    }

    /**
     * Get related guides (same locale).
     */
    public function relatedGuides()
    {
        if (empty($this->related_guide_slugs)) {
            return Guide::published()->locale($this->locale)->limit(3)->get();
        }
        return Guide::published()->locale($this->locale)
            ->whereIn('slug', $this->related_guide_slugs)->get();
    }

    /**
     * Get related audits (same locale, same type, excluding self).
     */
    public function relatedAudits()
    {
        if (empty($this->related_audit_slugs)) {
            return self::published()->locale($this->locale)
                ->where('id', '!=', $this->id)
                ->limit(2)->get();
        }
        return self::published()->locale($this->locale)
            ->whereIn('slug', $this->related_audit_slugs)->get();
    }

    /**
     * Get the full URL path for this audit.
     */
    public function getUrlAttribute(): string
    {
        $prefix = match ($this->locale) {
            'ru' => '/ru',
            'en' => '/en',
            default => '',
        };
        return "https://cityee.ee{$prefix}/audits/{$this->slug}/";
    }

    public function getServiceRouteAttribute(): ?string
    {
        if (!$this->service_link_key) return null;
        return "{$this->locale}.{$this->service_link_key}";
    }
}
