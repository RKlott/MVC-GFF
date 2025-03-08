<?php

use Core\Router;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Création du routeur
$router = new Router();

// Définition des routes
$router->add('', 'HomeController', 'index');
$router->add('admin', 'AdminController', 'index');
$router->add('admin/login', 'AdminController', 'login');

// Dispatcher l'URL
$router->dispatch($_SERVER['REQUEST_URI']);
