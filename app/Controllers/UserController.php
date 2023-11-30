<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends MainController
{
    public function renderUser() 
    {
        if($this->view === 'logout') {
            $this->logout();
        } else {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                if(isset($_POST["registerForm"])) {
                    $this->register();
                } elseif(isset($_POST["loginForm"])) {
                    $this->login();
                }  
            }
        }
        
        $this->render();
    }

    public function register()
    {
        function sanitize_input($data) {

            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
        }

        $firstname = sanitize_input($_POST['firstname']);
        $lastname = sanitize_input($_POST['lastname']);
        $email = sanitize_input($_POST['email']);

        $errors = 0;

        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (!$email || !$password || !$firstname || !$lastname) {
            $errors = 1;
            $this->data[] = '<div class="alert">All fields are mandatory !</div>';
        }

        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            $errors = 1;
            $this->data[] = '<div class="alert">The email format is invalid.</div>';
        }

        if (strlen($password) < 8) {
            $errors = 1;
            $this->data[] = '<div class="alert">The password must contain at least 8 characters.</div>';
        }

        if ($errors < 1) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new UserModel();

            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);
            $user->setRole(2);

            if ($errors < 1) {

                if ($user->registerUser()) {
                    $this->data[] = '<div class="checked">Successful registration, you can now log in.</div>
                                    <a class="a-user" href="?page=login">Log in</a>';
                } else {
                    $this->data[] = '<div class="alert">There was an error saving</div>';
                }
            }  
        }      
    }

    public function login()
    {   
        $errors = 0;
        $user = new UserModel();
        $user = $user->getUserByEmail($_POST['email']);

        if ($user === false) {
            $errors = 1;

        } else {

            if (password_verify($_POST['password'], $user->getPassword())) {

                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_role'] = $user->getRole();
    
                $this->data[] = '<div class="checked"> <h3>Successful connection !<h3/> </div>';
    
                if($_SESSION['user_role'] < 2) {
                    header('Location:?page=admin');
                }
            } else {
                $errors = 1;
            }
        } 
        if ($errors > 0) {
            $this->data[] = '<div class="alert">Incorrect email or password</div>';
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