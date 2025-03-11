<?php

namespace App\Core;

class View
{
    public static function render($view, $data = [])
    {
        // Convertir les clés du tableau associatif en variables
        extract($data);

        // Construire le chemin de la vue
        $viewPath = "../views/$view";

        // Vérifier si la vue existe
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("La vue '$view' est introuvable.");
        }
    }
}
