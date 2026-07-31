<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\Attribution\LeadService;
use Illuminate\Http\Request;

/**
 * Lead forms. Each submission is now saved server-side with first/last-touch
 * attribution (X999^5) BEFORE the notification email is sent, so a lead is never
 * lost if mail fails. Email content + validation rules are unchanged. PII is no
 * longer written to application logs.
 */
class ContactController extends Controller
{
    public function callback(Request $request, LeadService $leads)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tel'  => 'required|string|max:50',
        ], [
            'name.required' => 'Palun sisestage Teie nimi. / Пожалуйста, введите Ваше имя.',
            'tel.required'  => 'Palun sisestage telefoninumber. / Пожалуйста, введите номер телефона.',
        ]);

        $lead = $leads->record($request, 'callback', [
            'name'  => $validated['name'],
            'phone' => $validated['tel'],
        ], function (Lead $lead) {
            $name = htmlspecialchars((string) $lead->name);
            $tel  = htmlspecialchars((string) $lead->phone);
            $subject = "Новая заявка на обратный звонок / Telli kõne";
            $message = "Поступила новая заявка на обратный звонок!\n\n"
                . "Имя: {$name}\nТелефон: {$tel}\n\nОтправлено с сайта cityee.ee";
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\nContent-type: text/plain; charset=utf-8\r\n";
            return mail("info@cityee.ee", $subject, $message, $headers);
        });

        return $this->ok($lead);
    }

    public function inquiry(Request $request, LeadService $leads)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'tel'     => 'required|string|max:50',
            'email'   => 'nullable|email|max:255',
            'comment' => 'nullable|string|max:2000',
        ], [
            'name.required' => 'Palun sisestage Teie nimi. / Пожалуйста, введите Ваше имя.',
            'tel.required'  => 'Palun sisestage telefoninumber. / Пожалуйста, введите номер телефона.',
            'email.email'   => 'Vale e-mail formaat. / Неверный формат email.',
        ]);

        $lead = $leads->record($request, 'inquiry', [
            'name'    => $validated['name'],
            'phone'   => $validated['tel'],
            'email'   => $validated['email'] ?? null,
            'message' => $validated['comment'] ?? null,
        ], function (Lead $lead) {
            $name    = htmlspecialchars((string) $lead->name);
            $tel     = htmlspecialchars((string) $lead->phone);
            $email   = htmlspecialchars((string) $lead->email);
            $comment = htmlspecialchars((string) $lead->message);
            $subject = "Новая заявка / Saada päring";
            $message = "Поступила новая заявка с сайта!\n\n"
                . "Имя: {$name}\nТелефон: {$tel}\n"
                . ($email ? "Email: {$email}\n" : '')
                . ($comment ? "Комментарий: {$comment}\n" : '')
                . "\nОтправлено с сайта cityee.ee";
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\nContent-type: text/plain; charset=utf-8\r\n";
            return mail("info@cityee.ee", $subject, $message, $headers);
        });

        return $this->ok($lead);
    }

    public function auditRequest(Request $request, LeadService $leads)
    {
        $validated = $request->validate([
            'link'     => 'nullable|url|max:500',
            'district' => 'nullable|string|max:255',
            'type'     => 'required|in:apartment,house,commercial',
            'goal'     => 'required|in:sell,rent',
            'contact'  => 'required|string|max:255',
            'language' => 'nullable|in:et,ru,en',
            'locale'   => 'nullable|string|max:5',
        ]);

        $lead = $leads->record($request, 'audit', [
            'phone'    => $validated['contact'],
            'metadata' => array_intersect_key($validated, array_flip(['link', 'district', 'type', 'goal', 'language', 'locale'])),
        ], function (Lead $lead) use ($validated) {
            $subject = "Audit Request / Auditi päring — cityee.ee";
            $message = "New audit request from cityee.ee\n\n"
                . "Link: " . ($validated['link'] ?? '-') . "\n"
                . "District: " . ($validated['district'] ?? '-') . "\n"
                . "Type: " . $validated['type'] . "\n"
                . "Goal: " . $validated['goal'] . "\n"
                . "Contact: " . htmlspecialchars((string) $lead->phone) . "\n"
                . "Language: " . ($validated['language'] ?? '-') . "\n";
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\nContent-type: text/plain; charset=utf-8\r\n";
            return mail("info@cityee.ee", $subject, $message, $headers);
        });

        return $this->ok($lead);
    }

    public function priceCalculator(Request $request, LeadService $leads)
    {
        $validated = $request->validate([
            'address'   => 'required|string|max:500',
            'area'      => 'nullable|numeric|min:1',
            'rooms'     => 'nullable|integer|min:1|max:20',
            'floor'     => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:100',
            'contact'   => 'required|string|max:255',
            'locale'    => 'nullable|string|max:5',
        ]);

        $lead = $leads->record($request, 'price_calculator', [
            'phone'    => $validated['contact'],
            'message'  => $validated['address'],
            'metadata' => array_intersect_key($validated, array_flip(['address', 'area', 'rooms', 'floor', 'condition', 'locale'])),
        ], function (Lead $lead) use ($validated) {
            $subject = "Price Calculator / Hinnakalkulaator — cityee.ee";
            $message = "New price calculator request from cityee.ee\n\n"
                . "Address: " . $validated['address'] . "\n"
                . "Area: " . ($validated['area'] ?? '-') . " m²\n"
                . "Rooms: " . ($validated['rooms'] ?? '-') . "\n"
                . "Floor: " . ($validated['floor'] ?? '-') . "\n"
                . "Condition: " . ($validated['condition'] ?? '-') . "\n"
                . "Contact: " . htmlspecialchars((string) $lead->phone) . "\n";
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\nContent-type: text/plain; charset=utf-8\r\n";
            return mail("info@cityee.ee", $subject, $message, $headers);
        });

        return $this->ok($lead);
    }

    /**
     * Success response — 200 once the lead is persisted (mail status is recorded on
     * the lead, not surfaced as failure, so no lead is lost / no duplicate retry).
     * Body is NON-PII (safe for the frontend generate_lead dataLayer push).
     */
    private function ok(Lead $lead)
    {
        return response()->json(['status' => 'OK', 'lead' => $lead->analyticsPayload()]);
    }
}
