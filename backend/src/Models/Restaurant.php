<?php

namespace Models;

require_once __DIR__ . '/../Config/Database.php';

use Config\Database;

class Restaurant
{

    public static function create(array $data): void
    {

        try {
            $connectionInstance = Database::getInstance();
            $connection = $connectionInstance->getConnection();
            $stmt = $connection->prepare('INSERT INTO restaurants (name, address, phone, logo_url, primary_color) VALUES (?,?,?,?,?)');
            $stmt->bind_param('sssss', $data['name'], $data['address'], $data['phone'], $data['logo_url'], $data['primary_color']);

            $stmt->execute();
            $stmt->close();

        } catch (\mysqli_sql_exception) {

            if (isset($stmt) && $stmt !== false) {

                $stmt->close();

            }

            throw new \Exception('Error interno al crear el restaurante.', 500);

        }
    }
    public static function getRestaurants(): bool|array|null
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare('SELECT * FROM restaurants');
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            while ($restaurant = $result->fetch_assoc()) {

                $restaurants[] = $restaurant;

            }

            return $restaurants;

        } else {

            return false;

        }

    }
}