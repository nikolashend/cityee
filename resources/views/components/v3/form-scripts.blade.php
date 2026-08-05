{{-- v3 form AJAX + scroll-smooth for anchor CTAs --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── AJAX submit for v3 forms ──
    document.querySelectorAll('[data-v3-form]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (form.dataset.submitting === '1') return;   // block double-submit
            form.dataset.submitting = '1';
            var btn = form.querySelector('button[type="submit"]');
            var msg = form.querySelector('.v3-form__success');
            btn.disabled = true;
            btn.textContent = '…';

            // Stable id decided BEFORE the request: sent to the backend AND reused
            // as the fallback event_id (never mint a fresh conversion id after success).
            var clientSubmissionId = (typeof cityeeStableSubmissionId === 'function')
                ? cityeeStableSubmissionId() : null;
            var body = new FormData(form);
            if (clientSubmissionId) body.append('client_submission_id', clientSubmissionId);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: body
            })
            .then(function (r) {
                // Read the raw body once; the canonical success predicate decides.
                return r.text().then(function (t) { return { ok: r.ok, status: r.status, text: t }; });
            })
            .then(function (res) {
                var parsed = null;
                try { parsed = JSON.parse(res.text); } catch (e) { parsed = null; }

                // Canonical success + fail-closed test gating in cityee-lead-tracking.js.
                var decision = (typeof cityeeHandleLeadResponse === 'function')
                    ? cityeeHandleLeadResponse({
                        httpOk: res.ok,
                        parsed: parsed,
                        rawText: res.text,
                        clientSubmissionId: clientSubmissionId
                      })
                    : { accepted: res.ok && parsed && parsed.status === 'OK' };

                if (decision.accepted) {
                    form.reset();
                    if (msg) msg.style.display = 'block';
                } else {
                    alert('Error. Please try again.');
                }
            })
            .catch(function () {
                alert('Network error.');
            })
            .finally(function () {
                form.dataset.submitting = '0';
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
