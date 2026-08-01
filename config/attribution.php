<?php

/**
 * Lead attribution + retention config (X999^5 §15). Single source of truth —
 * never hardcode these values elsewhere.
 */
return [
    // How long lead records are kept before they may be pruned.
    'lead_retention_days' => (int) env('LEAD_RETENTION_DAYS', 400),

    // First-party attribution session/cookie lifetime (informational; session driver governs actual TTL).
    'attribution_cookie_days' => (int) env('ATTRIBUTION_COOKIE_DAYS', 90),

    // Never prune leads newer than this many days, even if retention is shorter (safety floor).
    'prune_min_age_days' => (int) env('LEAD_PRUNE_MIN_AGE_DAYS', 90),
];
