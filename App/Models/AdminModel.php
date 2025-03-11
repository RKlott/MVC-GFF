<?php
namespace App\Models;

use PDO;
use App\Core\Database; // Assurez-vous que Database.php gère la connexion PDO

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT password FROM admins WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            return true;
        }
        return false;
    }

    public function getAdminByUsername($username)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
