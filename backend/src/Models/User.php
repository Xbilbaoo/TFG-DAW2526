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
            if (password_verify($password, $user['psswd'])) {

                $stmt->close();
                return $user;
            }
        }

        $stmt->close();
        return false;
    }

    public static function createUser($user)
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->prepare('INSERT INTO users (email,password_hash,role,avatar_url,restaurant_id) VALUES (?,?,?,?,?)');
        $stmt->bind_param('ssssi', $user['email'], $user['password'], $user['role'], $user['avatar_url'], $user['restaurant_id']);
        $stmt->execute();
        $stmt->close();

    }

    public static function getUsers(): array|bool
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->query('SELECT * FROM users');

        while ($user = $stmt->fetch_assoc()) {

            $users[] = $user;
        }

        if ($users) {

            return $users;

        } else {

            return false;
        }
    }

    public static function updateUser($id, $cif, $email, $password, $role)
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare();
        $stmt->bind_param();

        if ($stmt->execute()) {

            $stmt->execute();
            $stmt->close();
            return true;

        } else {

            $stmt->close();
            return false;
        }
    }

}