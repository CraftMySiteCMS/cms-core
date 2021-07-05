<?php
require_once('Lang/fr.php');

/* FRONT */
$router->scope('/posts', function($router) {
    $router->get('/:id', "posts#show");
    $router->post('/:id', function($id){ echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>';});
});

/* BACK */
$router->scope('/cms-admin/', function($router) {
    $router->get('posts', "posts#admin");
    $router->get('posts/list', "posts#admin");
    $router->get('posts/list/test', "posts#admin");
});