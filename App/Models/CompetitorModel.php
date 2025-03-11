<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class CompetitorModel
{
    public static function getAll()
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM competitors ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($data, $file)
    {
        $db = Database::getConnection();

        // Définir un chemin par défaut pour la photo
        $photoPath = 'assets/uploads/competitors/default.png';

        // Gérer l'upload de l'image si fournie
        if (!empty($file['name'])) {
            $uploadDir = "public/assets/uploads/competitors/";
            $fileName = uniqid() . "_" . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $photoPath = "assets/uploads/competitors/" . $fileName;
            }
        }

        // Insérer le compétiteur en base
        $stmt = $db->prepare("INSERT INTO competitors (first_name, last_name, discipline, status, photo_path) 
                              VALUES (:first_name, :last_name, :discipline, :status, :photo_path)");
        return $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'discipline' => $data['discipline'],
            'status' => $data['status'],
            'photo_path' => $photoPath
        ]);
    }

    public static function delete($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM competitors WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function getById($id)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM competitors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function update($data, $file)
    {
        $db = Database::getConnection();

        // Récupérer l'ancienne photo
        $stmt = $db->prepare("SELECT photo_path FROM competitors WHERE id = :id");
        $stmt->execute(['id' => $data['id']]);
        $competitor = $stmt->fetch();
        $photoPath = $competitor['photo_path']; // Garde l’image actuelle par défaut

        // Vérifier s'il y a une nouvelle image
        if (!empty($file['name'])) {
            $uploadDir = "public/assets/uploads/competitors/";
            $fileName = uniqid() . "_" . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                $photoPath = "assets/uploads/competitors/" . $fileName;
            }
        }

        // Mettre à jour le compétiteur en base
        $stmt = $db->prepare("UPDATE competitors 
                              SET first_name = :first_name, last_name = :last_name, 
                                  discipline = :discipline, status = :status, photo_path = :photo_path 
                              WHERE id = :id");

        return $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'discipline' => $data['discipline'],
            'status' => $data['status'],
            'photo_path' => $photoPath,
            'id' => $data['id']
        ]);
    }
}
