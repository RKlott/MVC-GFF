<?php

namespace App\Core;

class Controller
{
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    protected function render($view, $data = [])
    {
        extract($data);
        require_once "../views/$view.php";
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
