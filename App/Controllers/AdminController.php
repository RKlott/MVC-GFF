<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\AdminModel;

class AdminController
{
    private AdminModel $adminModel;

    public function __construct()
    {
        $pdo = Database::getInstance(); // Connexion centralisée
        $this->adminModel = new AdminModel($pdo);
    }

    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($this->adminModel->authenticate($username, $password)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                header('Location: /admin/dashboard');
                exit;
            } else {
                $error = "Identifiants incorrects.";
                require '../views/admin/login.php'; // Affichage de la vue login avec erreur
            }
        } else {
            require '../views/admin/login.php'; // Affichage de la vue login normale
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}
