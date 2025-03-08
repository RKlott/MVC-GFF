<?php
namespace App\Models;

use PDO;
use PDOException;

class AdminModel {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAdminByUsername(string $username) {
        try {
            $sql = "SELECT * FROM admins WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
