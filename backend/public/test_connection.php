<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../src/Config/Database.php';

use Config\Database;

header('Content-Type: application/json; charset=utf-8');

try {

    $isConnected = Database::testConnection();

    if ($isConnected) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Conexión a la base de datos establecida correctamente con mysqli."
        ]);
    } else {
        http_response_code(500);
        $db = Database::getInstance();
        echo json_encode([
            "status" => "error",
            "message" => "No se pudo conectar a la base de datos.",
            "details" => $db->getError()
        ]);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Excepción capturada al intentar conectar.",
        "details" => $e->getMessage()
    ]);
}
?>