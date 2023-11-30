<?php

namespace App\Models;

use App\Utility\DataBase;
use \PDO;

class PostModel {

    private $id;
    private $title;
    private $content;
    private $img;

    public static function getPost()
    {
        $pdo = DataBase::connectPDO();

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

    