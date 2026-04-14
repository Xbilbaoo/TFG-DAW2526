<?php

namespace Controllers;

require_once __DIR__ . '/../Models/Restaurant.php';

use Models\Restaurant;

class RestaurantController
{

    function createRestaurant(): void
    {

        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request']);
            return;

        }

        $name = $input['name'] ?? '';
        $address = $input['address'] ?? '';
        $phone = $input['phone'] ?? '';
        $primary_color = $input['primary_color'] ?? '';
        $logo_url = $input['logo_url'] ?? '';

        if (empty($input['name']) || empty($input['address']) || empty($input['phone']) || empty($input['primary_color'])) {

            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Bad request']);
            return;

        }

        $cleanInput = [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'primary_color' => $primary_color,
            'logo_url' => $logo_url
        ];

        try {

            Restaurant::create($cleanInput);
            http_response_code(201);
            echo json_encode(['success' => true, 'message' => 'Restaurante creado']);

        } catch (\Exception $e) {

            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);

        }

    }

    public function getAllRestaurants()
    {

        header('Content-Type: application/json');

        $restaurants = Restaurant::getRestaurants();

        if ($restaurants) {

            http_response_code(200);
            echo json_encode(['success' => true, 'restaurants' => $restaurants]);

        } else {

            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'No se encontraron resultados']);

        }

    }
}