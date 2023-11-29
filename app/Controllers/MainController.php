<?php

namespace App\Controllers;

class MainController 
{
    protected $view;
    protected $data;

    public function render(){ 

        $data = $this->data; 
           
        require __DIR__.'/../views/front/layouts/header.phtml';
        require __DIR__."/../views/front/partials/".$this->view.".phtml";
        require __DIR__.'/../views/front/layouts/footer.phtml';
        
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