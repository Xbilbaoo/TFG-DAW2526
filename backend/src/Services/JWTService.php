<?php

namespace Services;



class JwtService {
    private static $secret = 'Clave_Secreta_Super_Segura_TFG_DAW_2026';
    public static function generateToken($userData) {

        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        $payload = json_encode([

            'iat' => time(),

            'exp' => time() + (60 * 60 * 2),

            'data' => $userData

        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    }

    public static function verifyToken($token) {

        // 1. Separar el token en sus 3 partes
        $tokenParts = explode('.', $token);

        if (count($tokenParts) !== 3) {
            return false; // Formato inválido
        }

        $base64UrlHeader = $tokenParts[0];
        $base64UrlPayload = $tokenParts[1];
        $signatureProvided = $tokenParts[2];

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Comprobar si la firma que hemos calculado coincide con la del token
        if (!hash_equals($base64UrlSignature, $signatureProvided)) {
            return false; // El token ha sido manipulado
        }

        // Decodificar el payload para leer los datos
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

        // Comprobar si el token ha caducado
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        // ¡Todo correcto! Devolvemos solo los datos del usuario
        return $payload['data'];

    }

}