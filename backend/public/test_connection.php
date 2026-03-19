<?php

// Muestra errores en pantalla para facilitar la depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ajusta la ruta si Connection.php está dentro de alguna subcarpeta (por ejemplo: src/Models/Connection.php)
require_once __DIR__ . '/../src/Models/Connection.php';

use Models\Connection;

header('Content-Type: application/json; charset=utf-8');

try {
    // Llamamos al método estático que verifica la conexión
    $isConnected = Connection::testConnection();

    if ($isConnected) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "Conexión a la base de datos establecida correctamente con mysqli."
        ]);
    } else {
        http_response_code(500);
        // Si isConnected() devuelve false, obtenemos el error instanciando para depurar
        $db = Connection::getInstance();
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
