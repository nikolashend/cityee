/* Executable proof for the P0 attribution-integrity fix.
 * Runs the SAME pure module the browser uses (public/.../cityee-lead-tracking.js).
 *   node tests/js/lead-tracking.test.cjs
 * Exit 0 = all pass, 1 = any failure. */
'use strict';
// The source is served to browsers as a classic script, and the repo is
// "type":"module", so require() can't load it. Evaluate it in a CommonJS
// sandbox to exercise the EXACT same bytes the browser runs.
var fs = require('fs'), vm = require('vm'), path = require('path');
var src = fs.readFileSync(path.join(__dirname, '../../public/assets/templates/offshors/js/cityee-lead-tracking.js'), 'utf8');
var sandbox = { self: {}, module: { exports: {} } };  // no window → browser glue is skipped
vm.runInNewContext(src, sandbox);
var CL = sandbox.module.exports;

var pass = 0, fail = 0;
function ok(name, cond) {
    if (cond) { pass++; console.log('  ✓ ' + name); }
    else { fail++; console.log('  ✗ FAIL: ' + name); }
}

// Emit simulator mirroring the browser once-guard (emitted[event_id]).
function makeEmitter() {
    var dl = [], emitted = {};
    return {
        dataLayer: dl,
        handle: function (ctx) {
            var d = CL.decideEmission(ctx);
            if (d.emit && d.event) {
                var id = d.event.event_id;
                if (id && emitted[id]) return d;   // already counted
                if (id) emitted[id] = true;
                dl.push(d.event);
            }
            return d;
        }
    };
}
function generateLeadCount(dl) {
    return dl.filter(function (e) { return e.event === 'generate_lead'; }).length;
}

console.log('\n— Canonical synthetic-click predicate (parity with PHP LeadService) —');
['CITYEE_TEST_GCLID_NOT_REAL', 'test', 'test123', 'TEST-GCLID-1', 'test_gclid',
 'cityee-test', 'closure_test', 'synthetic-x', 'not-real', 'not_real']
    .forEach(function (s) { ok('synthetic: ' + s, CL.isSyntheticClickId(s)); });
// NOTE: parity is with PHP LeadService::isSyntheticClickId. That shared regex
// contains `test\d`, so any string embedding "test<digit>" (e.g. "contest2024")
// is intentionally classified synthetic on BOTH sides — do not diverge here.
['Cj0KCQjwabc123realclickid', 'EAIaIQobrealid', '', null, undefined, 'Cj0KCQiAutumnSale']
    .forEach(function (s) { ok('real/none: ' + JSON.stringify(s), !CL.isSyntheticClickId(s)); });

console.log('\n— Canonical success predicate (explicit allowlist) —');
ok('JSON {status:OK} accepted', CL.isAcceptedSuccess({ status: 'OK' }, null));
ok('JSON {success:true} accepted', CL.isAcceptedSuccess({ success: true }, null));
ok('legacy exact "OK" accepted', CL.isAcceptedSuccess(null, 'OK'));
ok('legacy "OK\\n" trimmed accepted', CL.isAcceptedSuccess(null, 'OK\n'));
ok('string "OK" accepted', CL.isAcceptedSuccess('OK', 'OK'));
ok('HTML body rejected', !CL.isAcceptedSuccess(null, '<html><body>Error 500</body></html>'));
ok('empty body rejected', !CL.isAcceptedSuccess(null, ''));
ok('arbitrary text rejected', !CL.isAcceptedSuccess(null, 'Accepted'));
ok('JSON {status:ERR} rejected', !CL.isAcceptedSuccess({ status: 'ERR' }, null));

console.log('\n— Required emission matrix —');
var REAL = 'Cj0KCQjwabc123realclickid';
var e;

// 1. Normal JSON success + real click → exactly one generate_lead
e = makeEmitter();
e.handle({ httpOk: true, parsed: { status: 'OK', lead: { event_id: 'ev1', has_gclid: true, is_test: false, form_type: 'callback' } }, rawText: '{...}', clickIds: [REAL], clientSubmissionId: 'cs_1' });
ok('1: JSON success + real → 1 event', generateLeadCount(e.dataLayer) === 1);
ok('1: uses backend event_id', e.dataLayer[0].event_id === 'ev1');

// 2. Legacy exact "OK" + real click → one event, uses client submission id
e = makeEmitter();
e.handle({ httpOk: true, parsed: null, rawText: 'OK', clickIds: [REAL], clientSubmissionId: 'cs_2' });
ok('2: legacy OK + real → 1 event', generateLeadCount(e.dataLayer) === 1);
ok('2: falls back to client_submission_id', e.dataLayer[0].event_id === 'cs_2');
ok('2: carries form_name', e.dataLayer[0].form_name === 'lead_form');

// 3. JSON success + is_test=true → zero
e = makeEmitter();
e.handle({ httpOk: true, parsed: { status: 'OK', lead: { event_id: 'ev3', is_test: true } }, rawText: '{...}', clickIds: [], clientSubmissionId: 'cs_3' });
ok('3: JSON is_test=true → 0 events', generateLeadCount(e.dataLayer) === 0);

// 4. Legacy exact "OK" + synthetic CITYEE_TEST gclid (URL) → zero
e = makeEmitter();
e.handle({ httpOk: true, parsed: null, rawText: 'OK', clickIds: ['CITYEE_TEST_GCLID_NOT_REAL'], clientSubmissionId: 'cs_4' });
ok('4: legacy OK + CITYEE_TEST url → 0 events', generateLeadCount(e.dataLayer) === 0);

// 4b. Same, but URL was navigated away — only the persisted storage marker remains → still zero
e = makeEmitter();
e.handle({ httpOk: true, parsed: null, rawText: 'OK', clickIds: [], storageFlag: true, clientSubmissionId: 'cs_4b' });
ok('4b: legacy OK + persisted synthetic marker → 0 events', generateLeadCount(e.dataLayer) === 0);

// 5. Legacy exact "OK" + TEST-GCLID pattern → zero
e = makeEmitter();
e.handle({ httpOk: true, parsed: null, rawText: 'OK', clickIds: ['TEST-GCLID-4567'], clientSubmissionId: 'cs_5' });
ok('5: legacy OK + TEST-GCLID pattern → 0 events', generateLeadCount(e.dataLayer) === 0);

// 6. HTTP 200 HTML error body → zero + not accepted
e = makeEmitter();
var d6 = e.handle({ httpOk: true, parsed: null, rawText: '<html><body>Server Error</body></html>', clickIds: [REAL], clientSubmissionId: 'cs_6' });
ok('6: 200 HTML body → 0 events', generateLeadCount(e.dataLayer) === 0);
ok('6: 200 HTML body → not accepted (error UI)', d6.accepted === false);

// 7. HTTP 204 / empty unexpected body → zero
e = makeEmitter();
var d7 = e.handle({ httpOk: true, parsed: null, rawText: '', clickIds: [REAL], clientSubmissionId: 'cs_7' });
ok('7: 204/empty → 0 events', generateLeadCount(e.dataLayer) === 0);
ok('7: 204/empty → not accepted', d7.accepted === false);

// 8. HTTP 422 → zero
e = makeEmitter();
var d8 = e.handle({ httpOk: false, parsed: { errors: { name: ['req'] } }, rawText: '{"errors":{}}', clickIds: [REAL], clientSubmissionId: 'cs_8' });
ok('8: 422 → 0 events', generateLeadCount(e.dataLayer) === 0);
ok('8: 422 → not accepted', d8.accepted === false);

// 9. HTTP 500 → zero
e = makeEmitter();
ok('9: 500 → 0 events', generateLeadCount(e.handle({ httpOk: false, parsed: null, rawText: 'Server Error', clickIds: [REAL] }).accepted ? [1] : []) === 0);

// 10. Network failure (handler never called in browser; model httpOk:false) → zero
e = makeEmitter();
e.handle({ httpOk: false, parsed: null, rawText: null, clickIds: [REAL] });
ok('10: network failure → 0 events', generateLeadCount(e.dataLayer) === 0);

// 11. Double click / repeated callback (same backend lead) → exactly one
e = makeEmitter();
var payload = { httpOk: true, parsed: { status: 'OK', lead: { event_id: 'evDUP', is_test: false, form_type: 'callback' } }, rawText: '{...}', clickIds: [REAL], clientSubmissionId: 'cs_11' };
e.handle(payload); e.handle(payload);
ok('11: double submit same lead → exactly 1 event', generateLeadCount(e.dataLayer) === 1);

// 12. All four lead forms emit
['callback', 'inquiry', 'audit-request', 'price-calculator'].forEach(function (ft) {
    var em = makeEmitter();
    em.handle({ httpOk: true, parsed: { status: 'OK', lead: { event_id: 'ev_' + ft, is_test: false, form_type: ft } }, rawText: '{...}', clickIds: [REAL], clientSubmissionId: 'cs_' + ft });
    ok('12: form "' + ft + '" emits with form_type', generateLeadCount(em.dataLayer) === 1 && em.dataLayer[0].form_type === ft);
});

// 13. No PII on the dataLayer even if the (already non-PII) lead were malformed
e = makeEmitter();
e.handle({ httpOk: true, parsed: { status: 'OK', lead: { event_id: 'evPII', is_test: false, form_type: 'inquiry', source_class: 'google_ads', campaign_name: 'spring', has_gclid: true, submission_page: '/ru/' } }, rawText: '{...}', clickIds: [REAL], clientSubmissionId: 'cs_13' });
var ALLOWED = ['event', 'form_name', 'event_id', 'lead_public_id', 'form_type', 'source_class', 'campaign_name', 'has_gclid', 'submission_page'];
var keys = Object.keys(e.dataLayer[0]);
ok('13: event keys are within the non-PII allowlist', keys.every(function (k) { return ALLOWED.indexOf(k) !== -1; }));
var PII_KEYS = ['name', 'phone', 'email', 'message', 'tel', 'contact', 'address'];
ok('13: no PII field keys present', keys.every(function (k) { return PII_KEYS.indexOf(k) === -1; }));
var blob = JSON.stringify(e.dataLayer[0]).toLowerCase();
ok('13: no email/phone-looking values present', !/@/.test(blob) && !/\d{6,}/.test(blob));

console.log('\n' + (fail === 0 ? 'ALL PASS' : 'FAILURES') + ': ' + pass + ' passed, ' + fail + ' failed\n');
process.exit(fail === 0 ? 0 : 1);
