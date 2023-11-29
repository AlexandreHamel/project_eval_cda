<?php

namespace App\Models;

use \PDO;
use \PDOException;

class PostModel {

    private $id;
    private $title;
    private $content;
    private $img;

    public static function getPost()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=project_cda_1', 'root', '');
            echo 'connecté';
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        $sql = 'SELECT posts.id, posts.title, posts.content, posts.image
                FROM posts';

        $query = $pdo->prepare($sql);
        $query->execute();
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    }

    public function getId(): int
    {
        return $this->id;   
    }
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImg(): string
    {
        return $this->img;
    }
    public function setImg(string $img): void
    {
        $this->img = $img;
    }
}

    