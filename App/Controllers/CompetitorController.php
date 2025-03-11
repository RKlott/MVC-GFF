<?php
namespace App\Controllers;

use App\Models\CompetitorModel;
session_start();

class CompetitorController {
    private $competitorModel;

    public function __construct() {
        $this->competitorModel = new CompetitorModel();
        
        // Vérification de l'authentification de l'admin
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }
        
        // Gestion du timeout de session
        if (!isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
        } elseif (time() - $_SESSION['last_activity'] > 1800) { // Déconnexion après 30 min d'inactivité
            session_unset();
            session_destroy();
            header('Location: /admin/login');
            exit;
        }
        $_SESSION['last_activity'] = time();
    }

    public function index() {
        $competitors = $this->competitorModel->getAll();
        require_once '../views/admin/competitors/index.php';
    }

    public function show($id) {
        $competitor = $this->competitorModel->getById($id);
        require_once '../views/admin/competitors/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->competitorModel->add($_POST, $_FILES['photo']);
            header('Location: /admin/competitors');
        } else {
            require_once '../views/admin/competitors/create.php';
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->competitorModel->update($_POST, $_FILES['photo']);
            header('Location: /admin/competitors');
        } else {
            $competitor = $this->competitorModel->getById($id);
            require_once '../views/admin/competitors/edit.php';
        }
    }

    public function delete($id) {
        $this->competitorModel->delete($id);
        header('Location: /admin/competitors');
    }
}
