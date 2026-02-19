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
                if (r.ok) {
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
