<?php


namespace Models;

require_once __DIR__ . "/../Config/Database.php";

use Config\Database;

class User
{

    public static function hasPermission($email, $password): bool|array|null
    {
        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();


        $stmt = $connection->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {

                $stmt->close();
                return $user;

            }
        }

        $stmt->close();
        return false;
    }

    public static function createUser($userData): bool
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare('INSERT INTO users (email, password_hash, role, avatar_url, restaurant_id) VALUES (?,?,?,?,?)');

        $password = password_hash($userData['password'], PASSWORD_DEFAULT);

        $stmt->bind_param('ssssi', $userData['email'], $password, $userData['role'], $userData['avatar_url'], $userData['restaurant_id']);

        $success = $stmt->execute();

        $stmt->close();
        return $success;

    }

}