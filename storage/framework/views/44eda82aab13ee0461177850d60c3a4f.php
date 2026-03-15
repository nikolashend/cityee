
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

    /* ── 3. Central push function (global) ── */
    window.cityeeTrackLead = function (leadType, leadSource) {
        window.dataLayer.push({
            event:       'lead_submit_success',
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
<?php /**PATH C:\Users\nikol\Documents\projects\cityee-laravel\resources\views/partials/datalayer-leads.blade.php ENDPATH**/ ?>