<?php

namespace App\Support;

/**
 * Accessor for the TrustClaimRegistry (config/trust_claims.php).
 *
 * CITYEE X999 §51 / addendum #4 — single source of truth for factual claims.
 * Templates and schema builders read claims through here so a fact can never
 * drift between pages. Never hardcode commission / experience / sale-time
 * numbers in a Blade file; add or read them here instead.
 */
class TrustClaims
{
    /** Raw claim array by key. */
    public static function get(string $key): array
    {
        return config("trust_claims.{$key}", []);
    }

    /** Short display value, e.g. "10+", "300+", "2%". */
    public static function value(string $key): ?string
    {
        return config("trust_claims.{$key}.value");
    }

    /** Localized label for a claim, falling back to en then et. */
    public static function label(string $key, ?string $locale = null): string
    {
        $locale = $locale ?: (app()->getLocale() ?: 'et');
        $labels = config("trust_claims.{$key}.label", []);
        return $labels[$locale] ?? $labels['en'] ?? $labels['et'] ?? '';
    }

    // ─── Convenience accessors for the four headline stats ─────────

    public static function experienceValue(): string
    {
        return config('trust_claims.experience_years.value', '10+');
    }

    public static function dealCountValue(): string
    {
        return config('trust_claims.deal_count.value', '300+');
    }

    /** Headline commission ("2%"), the exclusive-agreement minimal fee. */
    public static function commission(): string
    {
        return config('trust_claims.commission.headline', '2%');
    }

    /** Full sanctioned commission sentence for the given locale. */
    public static function commissionSentence(?string $locale = null): string
    {
        $locale = $locale ?: (app()->getLocale() ?: 'et');
        $s = config('trust_claims.commission.sentence', []);
        return $s[$locale] ?? $s['en'] ?? $s['et'] ?? '';
    }

    /** Average sale time in days, as a display string ("45"). */
    public static function avgSaleDays(): string
    {
        return config('trust_claims.avg_sale.days_value', '45');
    }

    /** Average sale time in months ("1–1.5" en / "1–1,5" ru/et). */
    public static function avgSaleMonths(?string $locale = null): string
    {
        $locale = $locale ?: (app()->getLocale() ?: 'et');
        $v = config('trust_claims.avg_sale.months_value', '1–1,5');
        return $locale === 'en' ? str_replace(',', '.', $v) : $v;
    }

    /** Localized "avg sale" label for the days representation. */
    public static function avgSaleDaysLabel(?string $locale = null): string
    {
        $locale = $locale ?: (app()->getLocale() ?: 'et');
        $l = config('trust_claims.avg_sale.days_label', []);
        return $l[$locale] ?? $l['en'] ?? $l['et'] ?? '';
    }

    /** Localized "avg sale" label for the months representation. */
    public static function avgSaleMonthsLabel(?string $locale = null): string
    {
        $locale = $locale ?: (app()->getLocale() ?: 'et');
        $l = config('trust_claims.avg_sale.months_label', []);
        return $l[$locale] ?? $l['en'] ?? $l['et'] ?? '';
    }

    public static function googleRating(): string
    {
        return config('trust_claims.google_rating.value', '5.0');
    }
}
