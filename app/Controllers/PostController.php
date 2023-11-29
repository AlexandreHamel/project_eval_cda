<?php

namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\PostModel;

class PostController extends MainController
{
    public function renderPost()
    {
        $this->data = PostModel::getPost();

        $this->render();

    }
}