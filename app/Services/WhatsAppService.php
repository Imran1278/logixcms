<?php

namespace App\Services;

class WhatsAppService
{
    /**
     * Generate direct wa.me URL for one-click WhatsApp message sending (100% Free)
     */
    public function getWhatsAppLink(?string $to, string $message): string
    {
        if (empty($to)) {
            return '#';
        }

        $formattedNumber = $this->formatPhoneNumber($to);
        $encodedMessage = rawurlencode($message);

        return "https://wa.me/{$formattedNumber}?text={$encodedMessage}";
    }

    /**
     * Normalize mobile numbers to Pakistani country code format (e.g. 923001234567)
     */
    private function formatPhoneNumber(string $number): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($cleaned, '0')) {
            return '92' . substr($cleaned, 1);
        }

        return $cleaned;
    }
}