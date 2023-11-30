<?php

namespace App\Models;

use App\Utility\DataBase;
use \PDO;

class UserModel
{
    private $id;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $role;

    public function registerUser()
    {
        $pdo = DataBase::connectPDO();

        $sql = 'INSERT INTO users (firstname, lastname, email, password, role)
                VALUES (:firstname, :lastname, :email, :password, :role)';

        $pdoStatement = $pdo->prepare($sql);

        $params = [
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':email' => $this->email,
            ':password' => $this->password,
            ':role' => 2,
        ];

        $querystatus = $pdoStatement->execute($params);

        return $querystatus;
    }

    public function getUserByEmail($email)
    {
        $pdo = DataBase::connectPDO();
        
        $sql = 'SELECT users.id, users.email, users.password ,users.role 
                FROM users 
                WHERE email = :email';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([':email' => $email]);
        $result = $pdoStatement->fetchObject('App\Models\UserModel');

        return $result;
    }

    // CRUD USER

    public static function getUsers(): array
    {
        $pdo = DataBase::connectPDO();

        $sql = 'SELECT users.id, users.lastname, users.firstname, users.email, 
                    users.password, users.role
                FROM users
                ORDER BY id DESC';
        $query = $pdo->prepare($sql);
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\UserModel');

        return $users;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getRole(): int
    {
        return $this->role;
    }
    public function setRole(int $role): void
    {
        $this->role = $role;
    }
}