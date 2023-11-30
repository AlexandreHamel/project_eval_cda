<?php

namespace App\Controllers;

use App\Controllers\MainController;

class AdminController extends MainController
{
    public function renderAdmin()
    {
        $this->checkUserRole(1);

        $this->viewType = 'admin';

        $this->render();
    }
}