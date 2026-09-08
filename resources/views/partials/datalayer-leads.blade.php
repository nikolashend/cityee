{{-- ══════════════════════════════════════════════════════════════════════
     CONTACT-LINK CLICK TRACKING — dataLayer / GTM
     Event: contact_link_click  (NOT a form lead)

     X999⁵ F4 fix. Previously this pushed `lead_submit_success`, which the GTM
     "generate_lead" tags trigger on — so tel/WhatsApp/Telegram/email CLICKS were
     being counted as form leads. Contact links are observational, never the lead
     conversion, so the event is renamed to `contact_link_click`. Form submits fire
     `generate_lead` from cityee-lead-tracking.js — a separate, authoritative path.

     ⚠ DEPLOY ORDER: ship this ONLY AFTER GTM Owner Action B repoints the single
     generate_lead tag to the Custom Event `generate_lead`. If shipped before B,
     nothing pushes `lead_submit_success` and forms have no matching trigger yet, so
     `generate_lead` would fire from nothing until B lands. See
     docs/CITYEE_GTM_OWNER_ACTIONS_A_B_C.md.
     ══════════════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    /* ── 1. Ensure dataLayer exists (GTM may already init it) ── */
    window.dataLayer = window.dataLayer || [];

    /* ── 2. Detect page_type from body data-attribute or URL ── */
    function getPageType() {
        var el = document.body;
        if (el && el.dataset.pageType) return el.dataset.pageType;
        /* Fallback: URL-based detection */
        var p = location.pathname.replace(/^\/(ru|en)\//, '/');
        if (p === '/' || p === '') return 'homepage';
        if (/^\/(kontaktid|kontakty|contacts)\//.test(p)) return 'contacts';
        if (/^\/(juhendid|rukovodstva|guides)\//.test(p)) return 'blog';
        if (/^\/(auditid|audity|audits)\//.test(p)) return 'blog';
        if (/^\/(teadmistebaas|baza-znanij|knowledge)\//.test(p)) return 'blog';
        return 'other';
    }

    /* ── 3. Central push function (global) — contact-link click, NOT a lead ── */
    window.cityeeTrackLead = function (leadType, leadSource) {
        window.dataLayer.push({
            event:       'contact_link_click',
            lead_type:   leadType,
            lead_source: leadSource,
            page_type:   getPageType(),
            page_path:   location.pathname
        });
    };

    /* ── 4. Click listeners (tel / mailto / WhatsApp / Telegram) ── */
    document.addEventListener('DOMContentLoaded', function () {

        /* Phone */
        document.querySelectorAll('a[href^="tel:"]').forEach(function (el) {
            el.addEventListener('click', function () {
                cityeeTrackLead('phone', 'phone_click');
            });
        });

        /* Email */
        document.querySelectorAll('a[href^="mailto:"]').forEach(function (el) {
            el.addEventListener('click', function () {
                cityeeTrackLead('email', 'email_click');
            });
        });

        /* WhatsApp */
        document.querySelectorAll('a[href*="wa.me"]').forEach(function (el) {
            el.addEventListener('click', function () {
                cityeeTrackLead('messenger', 'whatsapp');
            });
        });

        /* Telegram */
        document.querySelectorAll('a[href*="t.me"]').forEach(function (el) {
            el.addEventListener('click', function () {
                cityeeTrackLead('messenger', 'telegram');
            });
        });
    });
})();
</script>
