<?php

namespace repositories;

use PDO;
use Database;
use PDOException;

class UserRepository
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY user_id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function deleteUserById($userId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $userId]);
    }

    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getUserByNickname($nickname)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE nickname = :nickname");
        $stmt->execute([':nickname' => $nickname]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function updateUserProfile($userId, $firstName, $lastName, $email)
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET first_name = :fname,
                last_name  = :lname,
                email      = :email
            WHERE user_id  = :uid
        ");
        $stmt->execute([
            ':fname' => $firstName,
            ':lname' => $lastName,
            ':email' => $email,
            ':uid'   => $userId
        ]);
    }

    public function createUser(
        $firstName,
        $lastName,
        $nickname,
        $email,
        $password,
        $city,
        $skillLevel,
        $position,
        $profilePicture = null,
        $role = 'USER'
    )
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users
                (first_name, last_name, nickname, email, password, city, skill_level, position, profile_picture, role)
                VALUES
                (:fname, :lname, :nick, :email, :pass, :city, :skill, :pos, :pic, :role)
            ");

            $stmt->execute([
                ':fname' => $firstName,
                ':lname' => $lastName,
                ':nick'  => $nickname,
                ':email' => $email,
                ':pass'  => $password,
                ':city'  => $city,
                ':skill' => $skillLevel,
                ':pos'   => $position,
                ':pic'   => $profilePicture,
                ':role'  => $role
            ]);
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
        }
    }

    public function userExistsById(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }


}