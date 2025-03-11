<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: /admin/login');
    exit;
}

$page = $_GET['page'] ?? 'dashboard';

require_once __DIR__ . '/../layouts/admin.php';
?>
