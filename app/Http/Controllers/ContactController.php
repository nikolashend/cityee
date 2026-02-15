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
            $mailSent = mail("nikolashend@gmail.com", $subject, $message, $headers);
            
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
            $mailSent = mail("nikolashend@gmail.com", $subject, $message, $headers);
            
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
}
