<?php

namespace App\Models;
use App\Utility\DataBase;
use \PDO;

class ContactModel
{
    private $id;
    private $name;
    private $mail;
    private $message;

    // CRUD CONTACT

    public function insertMessage()
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO contact (name, mail, message)
                VALUES (:name, :mail, :message)";
        $pdoStatement = $pdo->prepare($sql);
        $params = [
            ':name' => $this->name,
            ':mail' => $this->mail,
            ':message' => $this->message,
        ];
        $queryStatus = $pdoStatement->execute($params);
        return $queryStatus;
    }

    public static function getContacts(): array
    {
        $pdo = DataBase::connectPDO();
        $sql = 'SELECT contact.id, contact.name, 
                    contact.mail, contact.message
                FROM contact
                ORDER BY id DESC';
        $query = $pdo->prepare($sql);
        $query->execute();
        $contacts = $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\ContactModel');
        return $contacts;
    }

    public static function deleteContact(int $contactId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM contact
                WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $contactId, PDO::PARAM_INT);
        $queryStatus = $query->execute();
        return $queryStatus;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMail(): string
    {
        return $this->mail;
    }
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}