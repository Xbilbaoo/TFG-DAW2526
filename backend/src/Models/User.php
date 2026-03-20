<?php


namespace Models;

require_once __DIR__ . "/./Connection.php";

use Models\Connection;

class User
{

    public static function hasAdminPermission($username, $password, $role)
    {
        $connectionInstance = Connection::getInstance();
        $connection = $connectionInstance->getConnection();


        $stmt = $connection->prepare();
        $stmt->bind_param();
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

        $connectionInstance = Connection::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->prepare('INSERT INTO users (email,password_hash,role,avatar_url,restaurant_id) VALUES (?,?,?,?,?)');
        $stmt->bind_param('ssssi', $user['email'], $user['password'], $user['role'], $user['avatar_url'], $user['restaurant_id']);
        $stmt->execute();
        $stmt->close();
    }

    public static function getUserByID($id): array|bool
    {

        $connectionInstance = Connection::getInstance();
        $connection = $connectionInstance->getConnection();

        // Usar sentencias preparadas para prevenir inyección SQL
        $stmt = $connection->prepare();
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }

        $stmt->close();
        return false;
    }

    public static function getUsers(): array|bool
    {

        $connectionInstance = Connection::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->execute_query();

        while ($user = $stmt->fetch_assoc()) {

            $users[] = $user;
        }

        if ($users) {

            return $users;
        } else {

            return false;
        }
    }

    public static function createUserWithRole($cif, $email, $password, $role): bool
    {

        $connectionInstance = Connection::getInstance();
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

    public static function updateUser($id, $cif, $email, $password, $role)
    {

        $connectionInstance = Connection::getInstance();
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