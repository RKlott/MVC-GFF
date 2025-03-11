<?php

namespace App\Controllers;

use App\Models\MessagesModel;
use App\Core\View;

class MessagesController
{
    public function index()
    {
        $messages = MessagesModel::getAll();
        View::render('admin/messages/index.php', ['messages' => $messages]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['content'])) {
            MessagesModel::update($_POST['id'], $_POST['content']);
            header('Location: /admin/messages');
            exit;
        }
    }
}
