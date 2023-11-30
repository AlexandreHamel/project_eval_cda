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

    public static function getPostById(int $id) 
    {
        $pdo = DataBase::connectPDO();

        $query = $pdo->prepare('SELECT posts.id, posts.title, posts.content, posts.img 
                                FROM posts 
                                WHERE id=:id');

        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $post = $query->fetch();
        
        return $post;
    }

    // CRUD DES ARTICLES

    public function insertPost(): bool
    {
        $pdo = DataBase::connectPDO();

        $user_id = $_SESSION['user_id'];
        
        $sql = "INSERT INTO posts(title, content, img) 
                VALUES (:title, :content, :img)";
        
        $params = [
            'title' => $this->title,
            'content' => $this->content,
            'img' => $this->img,
        ];

        $query = $pdo->prepare($sql);     
        $query->execute($params);

        $postId = $pdo->lastInsertId();

        return $postId;
    } 

    // méthode qui return la requète SQL afin de modifier un Post
    public function updateOldPost(): bool
    {
        $pdo = DataBase::connectPDO();

        $user_id = $_SESSION['user_id'];
         
        $sql = "UPDATE `posts` 
                SET `title` = :title, `content` = :content, `img` = :img
                WHERE `id` = :id";
        
        $params = [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'img' => $this->img,
            'user_id' => $user_id
        ];

        $query = $pdo->prepare($sql);   
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deletePost(int $postId): bool
    {
        $pdo = DataBase::connectPDO();

        $sql = 'DELETE FROM posts 
                WHERE id = :id';

        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $postId, PDO::PARAM_INT);
        $queryStatus = $query->execute();
        return $queryStatus;
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

    