<?php

namespace Controllers;

use Models\User;
use Services\JwtService;

require_once __DIR__ . '../Models/User.php';
require_once __DIR__ . '../Services/JwtService.php';

class AuthController
{

    public static function login()
    {

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

            $user = User::hasPermission($email, $password);

            if ($user) {

                $cleanPayload = [
                    'user_id' => $user['user_id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                $token = JwtService::generateToken($cleanPayload);

                http_response_code(200);
                echo json_encode(['success' => true, 'token' => $token, 'user' => $cleanPayload]);
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