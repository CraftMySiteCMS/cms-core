<?php
require_once('lang/fr.php');

$router->scope('/posts', function($router) {
    $router->get('/:id', "news#show");
    $router->post('/:id', function($id){ echo 'Poster pour l\'article ' . $id . '<pre>' . print_r($_POST, true) . '</pre>';});
});

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    $router->get('/news', "news#admin");
    $router->get('/news/list', "news#admin");
});