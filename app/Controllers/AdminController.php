<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\ContactModel;

class AdminController extends MainController
{
    public function renderAdmin()
    {
        $this->checkUserRole(1);

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['deleteContactForm'])) {
                $this->removeContact();
            }
        }

        $this->viewType = 'admin';

        if(isset($this->subPage)) {
            $this->view = $this->subPage;

            if (isset($_POST["addPostForm"])) {
                $this->addPost();
            } 
            if (isset($_POST['deletePostForm'])) {
                $this->removePost();
            }
            if (isset($_POST['updatePostForm'])) {
                $this->updatePost();
            }
            if($this->view === 'adminUser') {
                $users = UserModel::getUsers();
                $this->data['users'] = $users;
            }
            if($this->view = 'adminContact') {
                $contacts = ContactModel::getContacts();
                $this->data['contact'] = $contacts;
            } 
        } else {
            $this->data['posts'] = PostModel::getPost();
        }
 
        $this->render();
    }

    // ADMIN POSTS

    public function addPost(): void
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_URL);

        $postModel = new PostModel();
        
        $postModel->setTitle($title);
        $postModel->setContent($content);
        $postModel->setImg($picture);

        $postId = $postModel->insertPost();

        if ($postId) {
            $this->data['infos'] = '<div class="checked">Article enregistré avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert">Il s\'est produit une erreur</div>';
        }
    }

    public function updatePost(): void
    {
        $id = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_URL);


        $postModel = new PostModel();     
        $postModel->setId($id);
        $postModel->setTitle($title);
        $postModel->setContent($content);
        $postModel->setImg($picture);
 

        if ($postModel->updateOldPost()) {
            $this->data['infos'] = '<div class="checked">Article modifié avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert">Il s\'est produit une erreur</div>';
        }
    }

    public function removePost(): void
    {
        $postId = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);

        if (PostModel::deletePost($postId)) {
            $this->data['infos'] = '<div class="checked">Article supprimé avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert">Il s\'est produit une erreur</div>';
        }
    }

    // ADMIN CONTACT

    public function removeContact(): void
    {
        $contactId = filter_input(INPUT_POST, 'contactid', FILTER_SANITIZE_NUMBER_INT);

        if(ContactModel::deleteContact($contactId)) {
            $this->data['infos'] = '<div class="checked">Contact supprimé avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert">Il s\'est produit une erreur</div>';
        }
    }
}