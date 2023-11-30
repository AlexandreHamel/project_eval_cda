<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends MainController
{
    public function renderUser() 
    {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(isset($_POST["registerForm"])) {
                $this->register();
            } elseif(isset($_POST["loginForm"])) {
                $this->login();
            }  
        }
        $this->render();
    }

    public function register()
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new UserModel();

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);
            $user->setRole(2);

            if ($user->registerUser()) {
                $this->data[] = '<div class="checked">Successful registration, you can now log in.</div>
                                <a class="a-user" href="?page=login">Log in</a>';
            }
    }

    public function login()
    {
        $user = new UserModel;

        if (password_verify($_POST['password'], $user->getPassword())) {

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_role'] = $user->getRole();

            $this->data[] = '<div class="checked"> <h3>Successful connection !<h3/> </div>';

            if($_SESSION['user_role'] < 2) {
                header('Location:?page=admin');
            }
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_role']);

        session_destroy();

        header('location:?page=logout');
    }
}