<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CallbackRequest;
use App\Mail\InquiryRequest;

class ContactController extends Controller
{
    public function callback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:50',
        ]);

        try {
            Mail::to('nikolashend@gmail.com')->send(new CallbackRequest($validated));
            return response()->json('OK');
        } catch (\Exception $e) {
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
        ]);

        try {
            Mail::to('nikolashend@gmail.com')->send(new InquiryRequest($validated));
            return response()->json('OK');
        } catch (\Exception $e) {
            return response()->json('Viga saatmisel / Ошибка отправки', 500);
        }
    }
}
