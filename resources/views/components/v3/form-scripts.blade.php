{{-- v3 form AJAX + scroll-smooth for anchor CTAs --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── AJAX submit for v3 forms ──
    document.querySelectorAll('[data-v3-form]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var btn = form.querySelector('button[type="submit"]');
            var msg = form.querySelector('.v3-form__success');
            btn.disabled = true;
            btn.textContent = '…';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: new FormData(form)
            })
            .then(function (r) {
                if (!r.ok) { alert('Error. Please try again.'); return null; }
                // On a 2xx with an unparseable body, still treat it as success ({}).
                return r.json().catch(function () { return {}; });
            })
            .then(function (data) {
                if (data === null) return;   // only null when the request failed (!r.ok)
                form.reset();
                if (msg) msg.style.display = 'block';
                // GTM / GA4 generate_lead — fire exactly once on confirmed success.
                // NOT gated on the lead payload, so a missing/legacy body still tracks.
                // event_id (when present) deduplicates GA4 vs Google Ads.
                var lead = data && data.lead;
                if (window.dataLayer && !(lead && lead.is_test)) {
                    window.dataLayer = window.dataLayer || [];
                    var evt = { event: 'generate_lead', form_name: 'lead_form' };
                    if (lead) {
                        evt.event_id        = lead.event_id;
                        evt.lead_public_id  = lead.lead_public_id;
                        evt.form_type       = lead.form_type;
                        evt.source_class    = lead.source_class;
                        evt.campaign_name   = lead.campaign_name || undefined;
                        evt.has_gclid       = !!lead.has_gclid;
                        evt.submission_page = lead.submission_page;
                    }
                    window.dataLayer.push(evt);
                }
            })
            .catch(function () {
                alert('Network error.');
            })
            .finally(function () {
                btn.disabled = false;
                btn.textContent = btn.dataset.label || btn.textContent;
            });
        });

        // Store original label
        var btn = form.querySelector('button[type="submit"]');
        if (btn) btn.dataset.label = btn.textContent;
    });

    // ── Smooth scroll for hero CTA anchors ──
    document.querySelectorAll('a[href^="#v3-form"]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            var target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
});
</script>
