<?php

namespace App\Helpers;

class Formatter
{
    public static function formatName(string $string): string
    {
        $formattedString = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
        $formattedString = preg_replace('/\s+/', '-', $formattedString);
        $formattedString = strtolower($formattedString);
        return $formattedString;
    }
}
