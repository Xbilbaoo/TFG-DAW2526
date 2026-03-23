<?php
// Mostramos errores para facilitar el desarrollo hoy
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuración de cabeceras (CORS y JSON)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Si es una petición OPTIONS (Pre-flight de Angular), salimos rápido
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 1. Requerimos las clases manualmente por hoy
require_once __DIR__ . '/../src/Config/Database.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';

// 2. Leemos qué URL nos están pidiendo
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 3. Enrutador muy simple
if (($url === '/login' || $url === '/index.php') && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new \Controllers\AuthController();
    $controller->login();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Ruta no encontrada o método incorrecto."]);
}