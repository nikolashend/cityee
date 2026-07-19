<?php

namespace App\Support;

/**
 * Accessor for the MoneyPageRegistry (config/money_pages.php).
 *
 * CITYEE X999 §20 / addendum #3 — one commercial intent = one canonical winner.
 * Winner/supporting values are SeoLinks page keys, resolved to URLs here so the
 * money-page map never stores raw URLs (single canonical URL source of truth).
 */
class MoneyPages
{
    /** All clusters, keyed by cluster id. */
    public static function all(): array
    {
        return config('money_pages', []);
    }

    /** One cluster definition, or null. */
    public static function cluster(string $id): ?array
    {
        return config("money_pages.{$id}");
    }

    /**
     * Resolve the winner URL for a cluster in a given locale (via SeoLinks).
     * Returns null when the cluster has no winner in that locale.
     */
    public static function winnerUrl(string $id, string $locale): ?string
    {
        $cluster = self::cluster($id);
        $pageKey = $cluster['winner'][$locale] ?? null;
        if (! $pageKey) {
            return null;
        }
        return SeoLinks::pageUrls($pageKey)[$locale] ?? null;
    }

    /**
     * Validate registry integrity: every winner/supporting page key must exist
     * in SeoLinks and resolve to a non-null URL for its declared locale.
     * Returns a list of human-readable problems (empty = OK).
     */
    public static function validate(): array
    {
        $problems = [];

        foreach (self::all() as $id => $cluster) {
            foreach (($cluster['winner'] ?? []) as $locale => $pageKey) {
                try {
                    $url = SeoLinks::pageUrls($pageKey)[$locale] ?? null;
                } catch (\Throwable $e) {
                    $problems[] = "{$id}: winner key '{$pageKey}' is not defined in SeoLinks";
                    continue;
                }
                if (! $url) {
                    $problems[] = "{$id}: winner '{$pageKey}' has no {$locale} URL in SeoLinks";
                }
            }

            foreach (($cluster['supporting'] ?? []) as $pageKey) {
                try {
                    SeoLinks::pageUrls($pageKey);
                } catch (\Throwable $e) {
                    $problems[] = "{$id}: supporting key '{$pageKey}' is not defined in SeoLinks";
                }
            }
        }

        return $problems;
    }
}
