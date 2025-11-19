<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toWhatsApp')) {
            $message = $notification->toWhatsApp($notifiable);

            // Assuming you have WhatsApp Business API or a service like Twilio
            // For demo purposes, we'll simulate sending via HTTP
            // Replace with actual WhatsApp API integration

            $phone = $notifiable->no_hp; // Assuming phone field exists
            if ($phone) {
                // Example: Send via WhatsApp API (replace with actual implementation)
                // Http::post('https://api.whatsapp.com/send', [
                //     'phone' => $phone,
                //     'message' => $message,
                // ]);

                // For now, log the message
                \Log::info("WhatsApp message to {$phone}: {$message}");
            }
        }
    }
}
