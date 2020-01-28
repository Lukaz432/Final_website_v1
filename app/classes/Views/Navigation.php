<?php

namespace App\Views;

use Core\View;

Class Navigation extends View
{
    public function __construct($data = [])
    {
        $this->data = [
            'left' => [
                [
                    'title' => 'Home',
                    'url' => '/index.php',
                ],
            ],
            'right' => [
                [
                    'title' => 'Login',
                    'url' => '/login.php',
                ],
                [
                    'title' => 'Register',
                    'url' => '/register.php',
                ],
                [
                    'title' => 'Logout',
                    'url' => '/logout.php',
                ],
            ],
        ];



    }

    public function render($template_path = ROOT . '/app/templates/Navigation.tpl.php')
    {
        return parent::render($template_path);
    }
}