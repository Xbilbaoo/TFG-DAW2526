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

    public static function getUsers(): array
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();
        $stmt = $connection->prepare('SELECT * FROM users');
        $stmt->execute();

        $result = $stmt->get_result();

        $users = [];

        if ($result->num_rows > 0) {

            while ($user = $result->fetch_assoc()) {

                $users[] = $user;

            }
        }

        return $users;

    }

    public static function createUser($userData)
    {
        try {
            $connectionInstance = Database::getInstance();
            $connection = $connectionInstance->getConnection();
            $stmt = $connection->prepare('INSERT INTO users (email, password_hash, role, avatar_url, restaurant_id) VALUES (?,?,?,?,?)');
            $password = password_hash($userData['password'], PASSWORD_DEFAULT);

            $stmt->bind_param('ssssi', $userData['email'], $password, $userData['role'], $userData['avatar_url'], $userData['restaurant_id']);


            $stmt->execute();
            $stmt->close();


        } catch (\mysqli_sql_exception $e) {

            if ($e->getCode() === 1062) {
                // Lanzamos una excepción personalizada
                throw new \Exception('El email ya está registrado.', 1062);
            } elseif ($e->getCode() === 1452) {
                throw new \Exception('El restaurante seleccionado no existe.', 1452);
            } else {
                throw new \Exception('Error interno en la base de datos.', 500);
            }
        }
    }

    public static function updateUserNoRole(array $cleanInput): array
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $password = password_hash($cleanInput['password'], PASSWORD_DEFAULT);
        $stmt = $connection->prepare('UPDATE users SET email = ?, password_hash = ?, avatar_url = ? WHERE user_id = ?');

        $stmt->bind_param('sssi', $cleanInput['email'], $password, $cleanInput['avatar_url'], $cleanInput['id']);

        try {

            $stmt->execute();

            if ($stmt->affected_rows === 0) {

                return ['success' => false, 'message' => 'Usuario no encontrado.', 'http_code' => 404];

            }

            $stmt->close();
            return ['success' => true, 'message' => 'Usuario actualizado correctamente.'];

        } catch (\mysqli_sql_exception $e) {

            error_log($e->getMessage());
            $stmt->close();

            if ($e->getCode() === 1062) {

                return ['success' => false, 'message' => 'El email ya esta registrado.', 'http_code' => 400];

            } elseif ($e->getCode() === 1452) {

                return ['success' => false, 'message' => 'El restaurante seleccionado no existe.', 'http_code' => 400];
            } else {

                return ['success' => false, 'message' => 'Error interno en la base de datos.', 'http_code' => 500];

            }
        }
    }

    public static function getUserById(int $id): array
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->prepare('SELECT * FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $user = [];

        while ($row = $result->fetch_assoc()) {

            $user = $row;
        }

        return $user;
    }

    public static function deleteUserById(int $id): bool
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $stmt = $connection->prepare('DELETE FROM users WHERE user_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {

            $stmt->close();
            return false;

        }

        if ($stmt->affected_rows === 1) {

            $stmt->close();
            return true;
        } else {

            $stmt->close();
            return false;
        }

    }

    public static function updateUser(array $cleanInput)
    {

        $connectionInstance = Database::getInstance();
        $connection = $connectionInstance->getConnection();

        $password = password_hash($cleanInput['password'], PASSWORD_DEFAULT);
        $stmt = $connection->prepare('UPDATE users SET email = ?, password_hash = ?, avatar_url = ? WHERE user_id = ?');

        $stmt->bind_param('sssi', $cleanInput['email'], $password, $cleanInput['avatar_url'], $cleanInput['id']);

        try {

            $stmt->execute();

            if ($stmt->affected_rows === 0) {

                throw new \Exception('Restaurante no encontrado.', 404);

            }

            $stmt->close();
            return true;

        } catch (\mysqli_sql_exception $e) {

            $stmt->close();

            if ($e->getCode() === 1062) {

                throw new \Exception('El email ya esta registrado.', 1062);

            } elseif ($e->getCode() === 1452) {

                throw new \Exception('El restaurante seleccionado no existe.', 1452);

            } else {

                throw new \Exception('Error interno en la base de datos.', 500);

            }
        }
    }

}