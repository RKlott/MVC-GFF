<?php

namespace App\Controllers;

use App\Models\MessagesModel as Message;
use App\Models\ScheduleModel as Schedule;
use App\Models\CompetitorModel as Competitor;
use App\Core\Database;
use App\Core\Controller;
use App\Core\View;

class AdminController extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: /admin/login');
            exit;
        }

        $messages = Message::getAll();
        $competitors = Competitor::getAll();
        $schedule = Schedule::get();

        View::render('admin/index.php', [
            'messages' => $messages,
            'competitors' => $competitors,
            'schedule' => $schedule
        ]);
    }

    public function login()
    {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $db = Database::getConnection();
            $query = "SELECT * FROM admin WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: /admin');
                exit;
            } else {
                header('Location: /admin/login?error=1');
                exit;
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /admin/login');
        exit;
    }

    public function updateMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['message'])) {
            Message::update($_POST['id'], $_POST['message']);
            header('Location: /admin');
            exit;
        }
    }

    public function uploadSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['schedule'])) {
            Schedule::update($_FILES['schedule']);
            header('Location: /admin');
            exit;
        }
    }

    public function addCompetitor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_competitor'])) {
            Competitor::add($_POST, $_FILES['photo'] ?? null);
            header('Location: /admin');
            exit;
        }
    }

    public function deleteCompetitor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_competitor'], $_POST['id'])) {
            Competitor::delete($_POST['id']);
            header('Location: /admin');
            exit;
        }
    }

    public function updateCompetitor()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_competitor'])) {
            Competitor::update($_POST, $_FILES['photo'] ?? null);
            header('Location: /admin');
            exit;
        }
    }
}
