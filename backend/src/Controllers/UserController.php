<?php

namespace Controllers;

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

                try {

                    User::createUser($cleanInput);
                    http_response_code(201);
                    echo json_encode(['success' => true, 'message' => 'Usuario creado']);

                } catch (\Exception $e) {


                    $codigoHttp = match ($e->getCode()) {
                        1062, 1452 => 400,
                        default => 500,
                    };

                    http_response_code($codigoHttp);
                    echo json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]);
                }

            }
        }
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

                try {

                    User::updateUserNoRole($cleanInput);
                    http_response_code(201);
                    echo json_encode(['success' => true, 'message' => 'Usuario actualizado']);

                } catch (\Exception $e) {

                    $codigoHttp = match ($e->getCode()) {
                        1062, 1452 => 400,
                        404 => 404,
                        default => 500,

                    };

                    http_response_code($codigoHttp);
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);

                }
            }

        }
    }

    public
    function getAllUsers(): void
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
    }

    public
    function getUserById(int $id): void
    {

        header('Content-Type: application/json');

        $user = User::getUserById($id);

        if (!$user) {

            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);

        } else {

            http_response_code(200);
            echo json_encode(['success' => true, 'user' => $user]);

        }

    }

    public
    function deleteUser(int $id): void
    {
        header('Content-Type: application/json');

        $result = User::deleteUserById($id);

        if (!$result) {

            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
            exit;

        } else {

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado.']);
            exit;

        }


    }

    public
    function updateWholeUser(string $id): void
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

                $cleanInput = ['id' => $id, 'email' => $input['email'], 'password' => $input['password'], 'role' => $input['role'], 'avatar_url' => $input['avatar_url'] ?? null, 'restaurant_id' => $input['restaurant_id']];

                try {

                    $result = User::updateUser($cleanInput);

                    if ($result) {

                        http_response_code(200);
                        echo json_encode(['success' => true, 'message' => 'Usuario actualizado.']);

                    }

                } catch (\Exception $e) {

                    $codigoHttp = match ($e->getCode()) {
                        1062, 1452 => 400,
                        404 => 404,
                        default => 500
                    };

                    http_response_code($codigoHttp);
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);

                }
            }
        }
    }
}