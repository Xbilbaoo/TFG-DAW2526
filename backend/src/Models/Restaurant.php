<?php

namespace Models;

require_once __DIR__ . '/../Config/Database.php';

use Config\Database;

class Restaurant
{

    public static function createRestaurant(array $data)
    {

        try {
            $connectionInstance = Database::getInstance();
            $connection = $connectionInstance->getConnection();
            $stmt = $connection->prepare('INSERT INTO restaurants (name, address, phone, logo_url, primary_color) VALUES (?,?,?,?,?)');
            $stmt->bind_param('sssss', $data['name'], $data['address'], $data['phone'], $data['logo_url'], $data['primary_color']);

            $stmt->execute();
            $stmt->close();

        } catch (\mysqli_sql_exception $e) {

            if ($e->getCode() === 1062) {

                throw new \Exception('Duplicate entry');

            }
        }
    }
}