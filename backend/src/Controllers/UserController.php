<?php

namespace Controllers;

use JetBrains\PhpStorm\NoReturn;
use Models\User;

require_once __DIR__ . '/../Models/User.php';

class UserController
{

    public function create(): void
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

                $cleanInput = ['email' => $input['email'], 'password' => $input['password'], 'role' => $input['role'], 'restaurant_id' => $input['restaurant_id'], 'avatar_url' => $input['avatar_url'] ?? null];

                $result = User::createUser($cleanInput);

                if ($result['success']) {

                    http_response_code(201);


                } else {

                    http_response_code($result['http_code']);

                }

                echo json_encode(['success' => $result['success'], 'message' => $result['message']]);

            }

        }

        exit;
    }

    public function updateWithoutRole($id): void
    {

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request.']);

        } else {

            if (empty($input['email']) || empty($input['password'])) {

                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Bad request.']);

            } else {

                $cleanInput = ['id' => $id, 'email' => $input['email'], 'password' => $input['password'], 'avatar_url' => $input['avatar_url'] ?? null];

                $result = User::updateUser($cleanInput);

                if ($result['success']) {

                    http_response_code(200);

                } else {

                    http_response_code($result['http_code']);

                }

                echo json_encode(['success' => $result['success'], 'message' => $result['message']]);

            }
        }

        exit;

    }

    public function getAllUsers(): void
    {

        header('Content-Type: application/json');

        $users = User::getUsers();

        if (!$users) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request.']);

        } else {

            http_response_code(200);
            echo json_encode(['success' => true, 'users' => $users]);
        }

        exit;
    }

    public function getUserById(int $id)
    {

        header('Content-Type: application/json');

        $user = User::getUserById($id);

        if (!$user) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request.']);

        } else {

            http_response_code(200);
            echo json_encode(['success' => true, 'user' => $user]);

        }

        exit;
    }
}