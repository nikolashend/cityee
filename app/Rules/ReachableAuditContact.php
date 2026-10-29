<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * The listing-audit form's contact contract: one telephone number, one
 * syntax-valid email address, OR one Telegram handle.
 *
 * Telegram is included for one reason only — the field's own label reads
 * "Telefon / WhatsApp / Telegram" on all three locales, so the page itself
 * offers that channel and a visitor who supplies "@owner_tallinn" has done
 * exactly what was asked. Rejecting it would be the page contradicting itself.
 *
 * The phone and email halves are NOT reimplemented here: they are delegated
 * verbatim to {@see ReachableContact}, the rule shipped and verified with the
 * price calculator on 2026-10-27 (83007d2). That class is left byte-unchanged,
 * so this form widens nothing for the calculator and the calculator's own
 * contract cannot drift through a shared edit.
 *
 * A Telegram handle is recognised only when it is explicitly marked:
 *
 *   @handle                     — leading "@", 5-32 legal characters
 *   t.me/handle                 — with or without scheme, or telegram.me
 *
 * A bare word is deliberately NOT accepted as a handle. Treating one as a
 * handle would re-open the door this release closes: "test", "nikol" and
 * "someusername" are all legal Telegram usernames in shape, so a bare-word
 * rule would accept the junk that the audit notification used to carry.
 *
 * Documented limits — syntax is not reachability:
 *   - a handle is not checked for existence; Telegram offers no such lookup
 *     without contacting their API, which this release does not do;
 *   - an email is judged by Laravel's own `email:rfc`, never a hand-rolled
 *     pattern, and so a syntactically valid address at a dead domain passes;
 *   - a string that contains a plausible 7-15 digit number passes even with
 *     words around it ("WhatsApp 5551234", "после 18:00 5551234"), because
 *     those words are usually genuine instructions and no safe way exists to
 *     tell them from filler. This is a known, accepted false-accept.
 */
class ReachableAuditContact implements ValidationRule
{
    /**
     * Telegram usernames are 5-32 characters of [A-Za-z0-9_] and must begin
     * with a letter. Dots are not legal, which is what keeps this pattern from
     * ever competing with an email address.
     */
    private const HANDLE = '/^[A-Za-z][A-Za-z0-9_]{4,31}$/';

    private const LINK = '~^(?:https?://)?(?:www\.)?(?:t|telegram)\.me/([A-Za-z][A-Za-z0-9_]{4,31})/?$~i';

    private const MESSAGES = [
        'et' => 'Palun sisestage telefoninumber, e-posti aadress või Telegrami kasutajanimi, et saaksime Teiega ühendust võtta.',
        'ru' => 'Пожалуйста, укажите телефон, email или имя в Telegram, чтобы мы могли с Вами связаться.',
        'en' => 'Please enter a phone number, an email address or a Telegram username so we can reply to you.',
    ];

    public function __construct(private readonly ?string $locale = null)
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contact = trim((string) $value);

        if ($contact === '') {
            $fail($this->message());
            return;
        }

        if ($this->isTelegram($contact)) {
            return;
        }

        // Everything else is judged by the already-shipped phone-or-email rule,
        // so this form can never be more permissive than the calculator on the
        // contact classes they share. Only the wording is this form's own.
        (new ReachableContact($this->locale))->validate(
            $attribute,
            $contact,
            function () use ($fail) {
                $fail($this->message());
            }
        );
    }

    private function isTelegram(string $contact): bool
    {
        if (preg_match(self::LINK, $contact)) {
            return true;
        }

        return str_starts_with($contact, '@')
            && (bool) preg_match(self::HANDLE, substr($contact, 1));
    }

    private function message(): string
    {
        return self::MESSAGES[$this->locale] ?? self::MESSAGES['ru'];
    }
}
