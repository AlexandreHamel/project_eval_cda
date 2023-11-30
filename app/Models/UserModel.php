<?php

namespace App\Models;

use \PDO;
use \PDOException;

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
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=project_cda_1', 'root', 'root');
            echo 'connecté';
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

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