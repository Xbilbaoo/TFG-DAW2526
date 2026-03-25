<?php


use Controllers\AuthController;
use Controllers\UserController;
use Services\JwtService;

require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';
require_once __DIR__ . '/../src/Services/JwtService.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);

$resource = $parts[1];
$id = $parts[2] ?? null;
$method = $_SERVER['REQUEST_METHOD'];


// Routing

switch ($resource) {

    case 'login':

        if ($method === 'POST') {

            $controller = new AuthController();
            $controller->login();

        } else {

            http_response_code(405);
            echo json_encode(["message" => 'método incorrecto.']);

        }

        break;

    case 'logout':

        if ($method === 'POST') {

            $controller = new AuthController();
            $controller->logout();

        } else {

            http_response_code(405);
            echo json_encode(["message" => 'método incorrecto.']);

        }

        break;

    case 'users':

        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'] ?? $_SERVER['HTTP_AUTHORIZATION'] ?? null;

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token no proporcionado o formato incorrecto.']);
            exit;
        }

        $token = $matches[1];

        $userData = JwtService::verifyToken($token);

        if (!$userData) {

            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Token inválido, manipulado o expirado.']);
            exit;

        }

        switch ($method) {

            case 'POST':

                if ($userData['role'] !== 'admin') {

                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'No tienes permisos para crear usuarios.']);
                    exit;

                }

                $controller = new UserController();
                $controller->create();
                break;

            case 'PUT':

                if ($id) {
                    $controller = new UserController();

                    if ($userData['role'] === 'admin') {

                        $controller->updateWholeUser($id);

                    } else {

                        if ((int)$userData['user_id'] !== (int)$id) {
                            http_response_code(403);
                            echo json_encode(['success' => false, 'message' => 'Solo puedes editar tu propio perfil.']);
                            exit;
                        }

                        $controller->updateWithoutRole($id);
                    }

                } else {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Falta el ID del usuario en la URL.']);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["message" => 'Método no permitido en esta ruta.']);
                break;
        }

    default:


}

