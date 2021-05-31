<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("Router/Router.php");
require_once("Router/Route.php");
require_once("Router/RouterException.php");

use CMS\Router\Router;
use CMS\Router\RouterException;

require_once("App/__controller.php");
require_once("App/__model.php");

$router = new Router($_GET['url']);

/* Pages simples */
$router->get('/', function(){ echo 'Homepage';});
$router->get('/posts', function(){ echo 'Tous les articles';});

/* Afficher une page avec plusieurs paramètres */
$router->get('/article/:id-:slug', function($id, $slug ) {echo "$id : $slug"; })->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');


/* Utilisation d'un Scope */
$router->scope('/posts', function($router) {

    $router->get('/:id', "news#show");
    $router->post('/:id', function($id){ echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>';});

});

try {
    $router->listen();
}
catch (RouterException $e) {
    echo $e->getMessage();
}