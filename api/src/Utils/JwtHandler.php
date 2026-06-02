<?php

namespace App\Utils;

class JwtHandler {
    private static $secret = "super_secret_key_change_in_production"; // Idealmente via env var

    public static function encode($payload) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60 * 24); // 24 hours
        $payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function decode($jwt) {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        list($header64, $payload64, $signature64) = $parts;

        $signature = hash_hmac('sha256', $header64 . "." . $payload64, self::$secret, true);
        $expectedSignature64 = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        if ($signature64 !== $expectedSignature64) {
            return null; // Invalid signature
        }

        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload64)), true);

        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null; // Expired
        }

        return $payload;
    }
}
