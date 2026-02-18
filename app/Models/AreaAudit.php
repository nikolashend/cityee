<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaAudit extends Model
{
    protected $fillable = [
        'slug', 'locale', 'title', 'meta_title', 'meta_description',
        'excerpt', 'content_blocks', 'og_image', 'priority',
        'published', 'published_at',
    ];

    protected $casts = [
        'content_blocks' => 'array',
        'published'      => 'boolean',
        'published_at'   => 'datetime',
        'priority'       => 'decimal:1',
    ];

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
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
}
