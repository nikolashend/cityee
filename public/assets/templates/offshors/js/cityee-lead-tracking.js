/* ==========================================================================
 * CityEE — canonical lead-conversion emission logic (single source of truth).
 *
 * Pure decision functions are UMD-exported so the browser AND the Node test
 * (tests/js/lead-tracking.test.cjs) run the EXACT same code. The browser-only
 * glue at the bottom wires them to the DOM / sessionStorage / dataLayer.
 *
 * Attribution-integrity contract (P0):
 *   - generate_lead fires ONLY on an explicitly allowlisted success response;
 *   - it is FAIL-CLOSED for synthetic/test clicks: any trusted signal that the
 *     session/click is a test click suppresses the event, even when the response
 *     carries no lead payload;
 *   - it fires exactly once per accepted backend lead (event_id de-dup);
 *   - no PII is ever placed on the dataLayer.
 * ========================================================================== */
;(function (root, factory) {
    var api = factory();
    if (typeof module === 'object' && module.exports) { module.exports = api; } // Node / tests
    root.CityeeLead = api;                                                       // browser
})(typeof self !== 'undefined' ? self : this, function () {
    'use strict';

    /* ── Canonical synthetic/test click-id predicate ──────────────────────────
     * MUST stay in sync with PHP App\Services\Attribution\LeadService::isSyntheticClickId().
     * A test click id must NEVER become a real GA4 / Google Ads conversion. */
    var SYNTHETIC_RE = /(^test|test\d|test[-_]?gclid|cityee[-_]?test|closure[-_]?test|synthetic|not[-_]?real)/i;

    function isSyntheticClickId(id) {
        return typeof id === 'string' && id !== '' && SYNTHETIC_RE.test(id);
    }

    /* ── Canonical success predicate — explicit allowlist ONLY ─────────────────
     * Accepts: parsed JSON {status:"OK"} or {success:true}; legacy body EXACTLY "OK".
     * Rejects: HTML, empty/204, proxy pages, arbitrary 2xx, non-"OK" strings. */
    function isAcceptedSuccess(parsed, rawText) {
        if (parsed && typeof parsed === 'object') {
            return parsed.status === 'OK' || parsed.success === true;
        }
        if (typeof parsed === 'string' && parsed.trim() === 'OK') return true; // jQuery may hand us the string
        if (typeof rawText === 'string' && rawText.trim() === 'OK') return true;
        return false;
    }

    /* ── Canonical test-context resolver — FAIL CLOSED ─────────────────────────
     * True if ANY trusted source indicates a synthetic/test click. Absence of a
     * lead payload must NOT disable this protection. */
    function isTestContext(opts) {
        opts = opts || {};
        if (opts.leadIsTest === true) return true;   // backend normalized flag (source of truth)
        if (opts.storageFlag === true) return true;  // persisted synthetic-landing marker
        var ids = opts.clickIds || [];               // live URL / persisted attribution state
        for (var i = 0; i < ids.length; i++) {
            if (isSyntheticClickId(ids[i])) return true;
        }
        return false;
    }

    function clickIdsFromSearch(search) {
        var out = [];
        try {
            var sp = new URLSearchParams(search || '');
            ['gclid', 'gbraid', 'wbraid'].forEach(function (k) {
                var v = sp.get(k);
                if (v) out.push(v);
            });
        } catch (e) { /* URLSearchParams unavailable → no ids */ }
        return out;
    }

    /* Build the non-PII generate_lead payload. event_id is decided BEFORE success:
     * backend event_id when present (canonical cross-channel de-dup key), else the
     * client submission id that was also sent with the request. Never minted anew. */
    function buildEvent(lead, clientSubmissionId) {
        var evt = { event: 'generate_lead', form_name: 'lead_form' };
        var eventId = (lead && lead.event_id) ? lead.event_id : (clientSubmissionId || null);
        if (eventId) evt.event_id = eventId;
        if (lead) {
            if (lead.lead_public_id)  evt.lead_public_id  = lead.lead_public_id;
            if (lead.form_type)       evt.form_type       = lead.form_type;
            if (lead.source_class)    evt.source_class    = lead.source_class;
            if (lead.campaign_name)   evt.campaign_name   = lead.campaign_name;
            evt.has_gclid = !!lead.has_gclid;
            if (lead.submission_page) evt.submission_page = lead.submission_page;
        }
        return evt;
    }

    /* Single pure decision used by BOTH transports and the test matrix. */
    function decideEmission(ctx) {
        ctx = ctx || {};
        var accepted = ctx.httpOk === true && isAcceptedSuccess(ctx.parsed, ctx.rawText);
        if (!accepted) return { accepted: false, isTest: false, emit: false, event: null };

        var lead = ctx.lead || (ctx.parsed && typeof ctx.parsed === 'object' ? ctx.parsed.lead : null) || null;
        var isTest = isTestContext({
            leadIsTest: !!(lead && lead.is_test),
            storageFlag: ctx.storageFlag === true,
            clickIds: ctx.clickIds || []
        });
        if (isTest) return { accepted: true, isTest: true, emit: false, event: null };

        return { accepted: true, isTest: false, emit: true, event: buildEvent(lead, ctx.clientSubmissionId) };
    }

    return {
        SYNTHETIC_RE: SYNTHETIC_RE,
        isSyntheticClickId: isSyntheticClickId,
        isAcceptedSuccess: isAcceptedSuccess,
        isTestContext: isTestContext,
        clickIdsFromSearch: clickIdsFromSearch,
        buildEvent: buildEvent,
        decideEmission: decideEmission
    };
});

/* ── Browser-only glue (skipped under Node) ──────────────────────────────── */
if (typeof window !== 'undefined' && window.document) {
    (function () {
        'use strict';
        var CL = window.CityeeLead;
        var STORAGE_KEY = 'cityee_test_lead';
        var emitted = {};   // event_id → true, guarantees exactly-once per lead

        function storageFlag() {
            try { return window.sessionStorage.getItem(STORAGE_KEY) === '1'; } catch (e) { return false; }
        }
        function markTest() {
            try { window.sessionStorage.setItem(STORAGE_KEY, '1'); } catch (e) { /* private mode */ }
        }

        // Persist a synthetic-landing marker so protection survives internal
        // navigation, mirroring the server-side session is_test flag.
        (function captureSyntheticLanding() {
            var ids = CL.clickIdsFromSearch(window.location.search);
            for (var i = 0; i < ids.length; i++) {
                if (CL.isSyntheticClickId(ids[i])) { markTest(); return; }
            }
        })();

        // Stable per-submission id generated BEFORE the request. Sent to the
        // backend (field: client_submission_id) and reused as the fallback event_id.
        window.cityeeStableSubmissionId = function () {
            try {
                if (window.crypto && window.crypto.randomUUID) return 'cs_' + window.crypto.randomUUID();
            } catch (e) { /* fall through */ }
            return 'cs_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 10);
        };

        // Central handler both transports call. Returns the decision; performs the
        // dataLayer push (once) when the decision says emit.
        window.cityeeHandleLeadResponse = function (ctx) {
            ctx = ctx || {};
            ctx.storageFlag = storageFlag();
            ctx.clickIds = CL.clickIdsFromSearch(window.location.search);
            var decision = CL.decideEmission(ctx);
            if (decision.emit && decision.event) {
                var id = decision.event.event_id;
                if (id && emitted[id]) return decision;   // already counted this lead
                if (id) emitted[id] = true;
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push(decision.event);
            }
            return decision;
        };
    })();
}
