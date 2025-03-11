<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class MessagesModel
{
    public static function getAll()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM scrolling_messages ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM scrolling_messages WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function update($id, $newMessage)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE scrolling_messages SET message = :message WHERE id = :id");
        return $stmt->execute([
            'message' => $newMessage,
            'id' => $id
        ]);
    }
}
