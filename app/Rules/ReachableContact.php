<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

/**
 * A contact an advisor can actually reply to: one telephone number OR one
 * syntax-valid email address.
 *
 * The price calculator promises a manual, individual price corridor, so a
 * request accepted without a usable channel is worse than a rejected one — the
 * owner believes they asked and nobody can answer. On 2026-10-26 a notification
 * arrived reading "Contact: Нет", because the field was validated only as
 * `required|string|max:255`.
 *
 * Deliberately lenient in the direction that protects real submissions:
 *
 *  - anything containing "@" is judged as an email by Laravel's own validator,
 *    never by a hand-rolled regex;
 *  - anything else is judged on its digits alone, so "+372 5555 1234",
 *    "(372) 555-11-22" and "WhatsApp 5551234" all pass;
 *  - 7 digits is the shortest Estonian landline, 15 the E.164 maximum, so that
 *    is the accepted range — foreign numbers are NOT blocked;
 *  - a run of one repeated digit, or a straight ascending/descending counting
 *    sequence, is rejected as obviously fictitious.
 *
 * Syntax is not deliverability: this proves a channel was offered, not that it
 * answers. No external lookup service is used.
 */
class ReachableContact implements ValidationRule
{
    /** Shortest Estonian landline. */
    private const MIN_DIGITS = 7;

    /** ITU-T E.164 maximum, country code included. */
    private const MAX_DIGITS = 15;

    /** Same inline-bilingual idiom the other lead forms already use. */
    private const MESSAGES = [
        'et' => 'Palun sisestage telefoninumber või e-posti aadress, et saaksime Teiega ühendust võtta.',
        'ru' => 'Пожалуйста, укажите телефон или email, чтобы мы могли с Вами связаться.',
        'en' => 'Please enter a phone number or an email address so we can reply to you.',
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

        if (str_contains($contact, '@')) {
            if (Validator::make(['email' => $contact], ['email' => 'email:rfc'])->fails()) {
                $fail($this->message());
            }
            return;
        }

        $digits = preg_replace('/\D+/', '', $contact);

        if (strlen($digits) < self::MIN_DIGITS || strlen($digits) > self::MAX_DIGITS) {
            $fail($this->message());
            return;
        }

        if ($this->isFictitious($digits)) {
            $fail($this->message());
        }
    }

    private function message(): string
    {
        return self::MESSAGES[$this->locale] ?? self::MESSAGES['ru'];
    }

    /** One repeated digit, or a straight counting sequence in either direction. */
    private function isFictitious(string $digits): bool
    {
        if (preg_match('/^(\d)\1+$/', $digits)) {
            return true;
        }

        $ascending = $descending = true;
        for ($i = 1, $n = strlen($digits); $i < $n; $i++) {
            $step = (int) $digits[$i] - (int) $digits[$i - 1];
            if ($step !== 1) {
                $ascending = false;
            }
            if ($step !== -1) {
                $descending = false;
            }
        }

        return $ascending || $descending;
    }
}
