<?php
namespace App\Controllers;

use App\Models\AdminModel;
use Core\Session;
use Core\Router;

class AuthController
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function login()
    {
        // Récupération de la méthode HTTP
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                Session::set('error', 'Veuillez remplir tous les champs.');
                $this->router->redirect('admin/login'); 
                return;
            }

            $adminModel = new AdminModel();
            $admin = $adminModel->getAdminByUsername($username);

            if ($admin && password_verify($password, $admin['password'])) {
                Session::set('admin_logged_in', true);
                Session::set('admin_id', $admin['id']);
                $this->router->redirect('/admin/dashboard');
            } else {
                Session::set('error', 'Identifiants incorrects');
                $this->router->redirect('admin/login');
            }
        }

        // Inclusion sécurisée de la vue
        require_once __DIR__ . '/../Views/admin/login.php';
    }

    public function logout()
    {
        Session::destroy();
        $this->router->redirect('admin/login');
    }
}
