<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function callback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:50',
        ], [
            'name.required' => 'Palun sisestage Teie nimi. / Пожалуйста, введите Ваше имя.',
            'tel.required' => 'Palun sisestage telefoninumber. / Пожалуйста, введите номер телефона.',
        ]);

        try {
            $name = htmlspecialchars($validated['name']);
            $tel = htmlspecialchars($validated['tel']);
            
            $subject = "Новая заявка на обратный звонок / Telli kõne";
            $message = "Поступила новая заявка на обратный звонок!\n\n";
            $message .= "Имя: " . $name . "\n";
            $message .= "Телефон: " . $tel . "\n\n";
            $message .= "Отправлено с сайта cityee.ee";
            
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";
            
            // Отправка через PHP mail()
            $mailSent = mail("info@cityee.ee", $subject, $message, $headers);
            
            // Логирование
            Log::channel('single')->info('Callback Request', [
                'name' => $name,
                'tel' => $tel,
                'mail_sent' => $mailSent
            ]);
            
            if ($mailSent) {
                return response()->json('OK');
            } else {
                return response()->json('Viga saatmisel / Ошибка отправки', 500);
            }
        } catch (\Exception $e) {
            Log::error('Callback Error: ' . $e->getMessage());
            return response()->json('Viga saatmisel / Ошибка отправки', 500);
        }
    }

    public function inquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'comment' => 'nullable|string|max:2000',
        ], [
            'name.required' => 'Palun sisestage Teie nimi. / Пожалуйста, введите Ваше имя.',
            'tel.required' => 'Palun sisestage telefoninumber. / Пожалуйста, введите номер телефона.',
            'email.email' => 'Vale e-mail formaat. / Неверный формат email.',
        ]);

        try {
            $name = htmlspecialchars($validated['name']);
            $tel = htmlspecialchars($validated['tel']);
            $email = htmlspecialchars($validated['email'] ?? '');
            $comment = htmlspecialchars($validated['comment'] ?? '');
            
            $subject = "Новая заявка / Saada päring";
            $message = "Поступила новая заявка с сайта!\n\n";
            $message .= "Имя: " . $name . "\n";
            $message .= "Телефон: " . $tel . "\n";
            if ($email) {
                $message .= "Email: " . $email . "\n";
            }
            if ($comment) {
                $message .= "Комментарий: " . $comment . "\n";
            }
            $message .= "\nОтправлено с сайта cityee.ee";
            
            $headers = "From: cityee.ee <noreply@cityee.ee>\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";
            
            // Отправка через PHP mail()
            $mailSent = mail("info@cityee.ee", $subject, $message, $headers);
            
            // Логирование
            Log::channel('single')->info('Inquiry Request', [
                'name' => $name,
                'tel' => $tel,
                'email' => $email,
                'comment' => $comment,
                'mail_sent' => $mailSent
            ]);
            
            if ($mailSent) {
                return response()->json('OK');
            } else {
                return response()->json('Viga saatmisel / Ошибка отправки', 500);
            }
        } catch (\Exception $e) {
            Log::error('Inquiry Error: ' . $e->getMessage());
            return response()->json('Viga saatmisel / Ошибка отправки', 500);
        }
    }

    /**
     * Audit request form (v3)
     */
    public function auditRequest(Request $request)
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

        try {
            $subject = "Audit Request / Auditi päring — cityee.ee";
            $message = "New audit request from cityee.ee\n\n";
            $message .= "Link: " . ($validated['link'] ?? '-') . "\n";
            $message .= "District: " . ($validated['district'] ?? '-') . "\n";
            $message .= "Type: " . $validated['type'] . "\n";
            $message .= "Goal: " . $validated['goal'] . "\n";
            $message .= "Contact: " . $validated['contact'] . "\n";
            $message .= "Language: " . ($validated['language'] ?? '-') . "\n";

            $headers  = "From: cityee.ee <noreply@cityee.ee>\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";

            $mailSent = mail("info@cityee.ee", $subject, $message, $headers);

            Log::channel('single')->info('Audit Request', $validated + ['mail_sent' => $mailSent]);

            return $mailSent
                ? response()->json('OK')
                : response()->json('Error', 500);
        } catch (\Exception $e) {
            Log::error('Audit Request Error: ' . $e->getMessage());
            return response()->json('Error', 500);
        }
    }

    /**
     * Price calculator form (v3)
     */
    public function priceCalculator(Request $request)
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

        try {
            $subject = "Price Calculator / Hinnakalkulaator — cityee.ee";
            $message = "New price calculator request from cityee.ee\n\n";
            $message .= "Address: " . $validated['address'] . "\n";
            $message .= "Area: " . ($validated['area'] ?? '-') . " m²\n";
            $message .= "Rooms: " . ($validated['rooms'] ?? '-') . "\n";
            $message .= "Floor: " . ($validated['floor'] ?? '-') . "\n";
            $message .= "Condition: " . ($validated['condition'] ?? '-') . "\n";
            $message .= "Contact: " . $validated['contact'] . "\n";

            $headers  = "From: cityee.ee <noreply@cityee.ee>\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";

            $mailSent = mail("info@cityee.ee", $subject, $message, $headers);

            Log::channel('single')->info('Price Calculator', $validated + ['mail_sent' => $mailSent]);

            return $mailSent
                ? response()->json('OK')
                : response()->json('Error', 500);
        } catch (\Exception $e) {
            Log::error('Price Calculator Error: ' . $e->getMessage());
            return response()->json('Error', 500);
        }
    }
}
