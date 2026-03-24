<?php

namespace Controllers;

use Models\User;

class AuthController
{

    public static function login() {

        require_once __DIR__ . '/../Models/User.php';

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $email = $input['email'] ?? null;
        $password = $input['password'] ?? null;

        if (empty($email) || empty($password)) {
            http_response_code(400); // 400 Bad Request
            echo json_encode(['success' => false, 'message' => 'Faltan los campos "email" o "password".']);
            exit;
        }

        try {

            $userData = User::hasPermission($email, $password);

            if ($userData) {

                $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

                $payload = json_encode([
                    'id' => $userData['user_id'],
                    'username' => $userData['email'],
                    'role' => $userData['role'],
                    'iat' => time(),
                    'exp' => time() + 3600
                ]);

                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

                $secret = 'Clave_Secreta_TFG_2526';
                $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

                $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'token' => $token,
                    'user' => [
                        'id' => $userData['user_id'],
                        'username' => $userData['email'],
                        'role' => $userData['role']
                    ]
                ]);
                exit;

            } else {

                http_response_code(401); // 401 Unauthorized
                echo json_encode(['success' => false, 'message' => 'Credenciales incorrectas.']);
                exit;
            }

        } catch (Exception $e) {

            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
            exit;

        }
    }


}