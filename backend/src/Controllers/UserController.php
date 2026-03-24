<?php

namespace Controllers;

use Models\User;

require_once __DIR__ . '/../Models/User.php';
class UserController
{
    public function create()
    {

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request.']);

        } else {

            if (empty($input['email']) || empty($input['password']) || empty($input['restaurant_id']) || empty($input['role'])) {

                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Bad request.']);

            } else {

                $cleanInput = [
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'role' => $input['role'],
                    'restaurant_id' => $input['restaurant_id'],
                    'avatar_url' => $input['avatar_url'] ?? null
                ];

                $isStored = User::createUser($cleanInput);

                if ($isStored) {

                    http_response_code(200);
                    echo json_encode(['success' => true, 'message' => 'Usuario creado.']);

                } else {

                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al crear usuario.']);

                }

            }

        }

        exit;
    }
}