<?php

namespace Core;

class Router
{
    protected $routes = [];

    public function add($route, $controller, $method)
    {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch($url)
    {
        $url = trim(parse_url($url, PHP_URL_PATH), '/');

        if (array_key_exists($url, $this->routes)) {
            $controllerName = "App\\Controllers\\" . $this->routes[$url]['controller'];
            $method = $this->routes[$url]['method'];

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    return $controller->$method();
                }
            }
        }

        http_response_code(404);
        echo "Page not found";
    }
}
