<?php

namespace App\Controllers;

use App\Models\ContactModel;

class ContactController extends MainController
{
    public function renderContact()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->insertContact();
            return;
        }
        $this->render();
    }

    public function insertContact()
    {
        $errors = 0;

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!$name || !$mail || !$message) {
            $errors = 1;
            echo json_encode(array('error' => "All fields are mandatory!"));
            exit();
        }

        $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
        if ($mail === false) {
            $errors = 1;
            echo json_encode(array('error' => filter_var($mail , FILTER_VALIDATE_EMAIL)));
            exit();       
        }

        if(strlen($message) < 10) {
            $errors = 1;
            echo json_encode(array('error' => 'The message is too short.' ));
            exit();
        }

        if ($errors < 1) {

            $contact = new ContactModel();

            $contact->setName($name);
            $contact->setMail($mail);
            $contact->setMessage($message);

            if($contact->insertMessage()) {
                echo json_encode(array('ok' => 'Thank you for your message, we will try to respond to you as quickly as possible.'));
                exit();
            } 
            else {
                echo json_encode(array('ok' => 'There was an error sending the message'));
                exit();
            }
        }
    }
}