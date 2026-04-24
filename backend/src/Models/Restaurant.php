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

    public static function getRestaurants(): bool|array
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare('SELECT * FROM restaurants');
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $restaurants = [];

            while ($restaurant = $result->fetch_assoc()) {

                $restaurants[] = $restaurant;

            }

            return $restaurants;

        } else {

            return false;

        }

    }

    public static function deleteRestaurantById(int $id)
    {
        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare('DELETE FROM restaurants WHERE restaurant_id = ?');
        $stmt->bind_param('i', $id);

        try {

            $stmt->execute();

            if ($stmt->affected_rows === 1) {

                $stmt->close();
                return true;

            } else {

                $stmt->close();
                return false;

            }

        } catch (\mysqli_sql_exception $e) {

            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }

            if($e->getCode() == 1451) {

                throw new \Exception('No se puede eliminar este restaurente. Hay datos vinculados a este restaurante.', 1451);

            } else {

                throw new \Exception('Error interno del servidor.', 500);

            }
        }
    }
}