<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

$router = new Router();

$router->get('admin/login', 'AuthController@login'); // Afficher formulaire
$router->post('admin/login', 'AuthController@login'); // Traiter connexion

$router->get('admin/logout', 'AuthController@logout');
$router->get('admin/messages', 'MessagesController@index');
$router->post('admin/messages/update', 'MessagesController@update');

$router->dispatch($_SERVER['REQUEST_URI']);
