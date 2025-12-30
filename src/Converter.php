<?php
namespace Nex;

class Converter {
    public static function convert($amount, $from = 'TRY', $to = 'USD') {
        $url = "https://api.exchangerate-api.com/v4/latest/{$from}";
        $json = @file_get_contents($url); // Hata bastırmak için @ koyduk
        
        if ($json === false) return ["error" => "API bağlantı hatası!"];

        $data = json_decode($json, true);
        if (!isset($data['rates'][$to])) return ["error" => "Döviz bulunamadı!"];

        $rate = $data['rates'][$to];
        return [
            'miktar' => $amount,
            'birim_den' => $from,
            'birim_e' => $to,
            'kur' => $rate,
            'sonuc' => round($amount * $rate, 2)
        ];
    }
}