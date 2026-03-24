<?php


use Controllers\AuthController;

require_once __DIR__ . '/../src/Controllers/AuthController.php';


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

        $controller = new AuthController();
        $controller->logout();
        break;

    default:


}

