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
                return r.json().catch(function () { return null; });
            })
            .then(function (data) {
                if (data === null) return;
                form.reset();
                if (msg) msg.style.display = 'block';
                /* GA4 generate_lead — NON-PII payload only (name/phone/email never sent) */
                if (window.dataLayer && data && data.lead) {
                    window.dataLayer.push({
                        event: 'generate_lead',
                        lead_public_id: data.lead.lead_public_id,
                        form_type: data.lead.form_type,
                        source_class: data.lead.source_class,
                        campaign_name: data.lead.campaign_name || undefined,
                        has_gclid: !!data.lead.has_gclid,
                        submission_page: data.lead.submission_page
                    });
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
