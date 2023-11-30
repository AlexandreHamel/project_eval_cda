<?php

namespace App\Controllers;

class MainController 
{
    protected $view;
    protected $data;
    protected $viewType = 'front';

    public function render(): void
    { 
        $data = $this->data; 
           
        require __DIR__.'/../views/' . $this->viewType . '/layouts/header.phtml';
        require __DIR__.'/../views/' . $this->viewType . '/partials/'.$this->view.'.phtml';
        require __DIR__.'/../views/' . $this->viewType . '/layouts/footer.phtml';
        
    }

    protected function checkUserRole(int $role): bool
    {
        if(isset($_SESSION['user_id'])) {
            
            $currentUserRole = $_SESSION['user_role'];
            
            if ($currentUserRole <= $role) {
                
                return true;
                
            } else {
                http_response_code(403);
                $this->view = '403';
                $this->render();
                
                exit();
            }
        } else {
            
            header('Location:/public/?page=login');
            
            exit();
        }
    }

    public function getView()
    {
        return $this->view;
    }
    public function setView($view)
    {
        $this->view = $view;
    }

    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;        
    }
}