<?php

use CMS\Router\RouterException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("Router/Router.php");
require_once("Router/Route.php");
require_once("Router/RouterException.php");

$router = new CMS\Router\Router($_GET['url']);

$router->get('/', function(){ echo 'Homepage';});
$router->get('/posts', function(){ echo 'Tous les articles';});
$router->get('/posts/:id', function($id){ ?>
    <form action="" method="post">
        <input type="text" name="name">
        <button type="submit">Envoyer</button>
    </form>

<?php });
$router->post('/posts/:id', function($id){ echo 'Poster pour l\'artrcile ' . $id . '<pre>' . print_r($_POST, true) . '</pre>';});

try {
    $router->run();
}
catch (RouterException $e) {}