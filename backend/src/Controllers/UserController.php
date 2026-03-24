<?php

namespace Controllers;

use Config\Database;
use Models\User;

class UserController
{

    public function create()
    {

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request.']);
            exit;

        } else {

            if (empty($input['email']) || empty($input['password']) || empty($input['restaurant_id']) || empty($input['role'])) {

                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Bad request.']);
                exit;

            } else {

                $cleanInput = [
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'role' => $input['role'],
                    'restaurant_id' => $input['restaurant_id']
                ];

                $isStored = User::createUser($cleanInput);

                if ($isStored) {

                    http_response_code(200);
                    echo json_encode(['success' => true, 'message' => 'Usuario creado.']);

                } else {

                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Error al crear usuario.']);
                }
                exit;
            }


        }
    }
}