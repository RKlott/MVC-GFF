<?php

namespace Core;

class Router
{
    protected $routes = [];
    protected $basePath = '/MVC-GFF'; // Mets à jour si nécessaire

    public function __construct()
    {
        var_dump("BasePath utilisé : " . $this->basePath); // DEBUG
    }

    public function add($route, $controllerMethod, $httpMethod)
    {
        $httpMethod = strtoupper($httpMethod);

        if (!isset($this->routes[$route])) {
            $this->routes[$route] = [];
        }

        $this->routes[$route][$httpMethod] = $controllerMethod;
    }

    public function dispatch($url)
    {
        $url = str_replace([$this->basePath, 'public/'], '', $url);
        $url = trim(parse_url($url, PHP_URL_PATH), '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        echo "<pre>URL traitée après nettoyage : $url</pre>";
        echo "<pre>Méthode HTTP de la requête : $requestMethod</pre>";
        echo "<pre>Routes enregistrées : " . print_r($this->routes, true) . "</pre>";

        // Vérifier si la route existe
        if (!isset($this->routes[$url])) {
            http_response_code(404);
            echo "Erreur 404 : Page non trouvée.";
            return;
        }

        // Vérifier si la méthode HTTP correspond
        if (!isset($this->routes[$url][$requestMethod])) {
            http_response_code(405);
            echo "Erreur 405 : Méthode non autorisée. (Méthodes acceptées : " . implode(", ", array_keys($this->routes[$url])) . ")";
            return;
        }

        // Exécuter le contrôleur et la méthode
        $controllerMethod = $this->routes[$url][$requestMethod];
        list($controllerName, $method) = explode('@', $controllerMethod);
        $controllerClass = "App\\Controllers\\" . $controllerName;

        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $method)) {
                return $controller->$method();
            }
        }

        http_response_code(500);
        echo "Erreur 500 : Le contrôleur ou la méthode spécifiée est introuvable.";
    }

    public function redirect($url)
    {
        // Vérifie si l'URL commence par "/"
        if (strpos($url, '/') !== 0) {
            $url = '/' . $url;
        }
    
        // Construit l'URL complète avec basePath correctement
        $fullUrl = rtrim($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $this->basePath, '/') . $url;
    
        header("Location: " . $fullUrl);
        exit;
    }
    

    

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function get($route, $controllerMethod)
    {
        $this->add($route, $controllerMethod, 'GET');
    }

    public function post($route, $controllerMethod)
    {
        $this->add($route, $controllerMethod, 'POST');
    }

    public function any($route, $controllerMethod)
    {
        $this->add($route, $controllerMethod, 'ANY');
    }
}
