<?php

namespace App\Models;

use App\Core\Database;

class ScheduleModel
{
    public static function get()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT image_path FROM schedule WHERE id = 1");
        return $stmt->fetch();
    }

    public static function update($file)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $uploadDir = "public/assets/uploads/schedule/";
        $fileName = uniqid() . "_" . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE schedule SET image_path = :image_path WHERE id = 1");
            return $stmt->execute(['image_path' => "/" . $filePath]);
        }

        return false;
    }
}
