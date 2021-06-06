<?php

/* Basic pages of CMS */
$router->get('/',"core#home");
$router->get('/test',"core#home");
$router->get('/test/tset',"core#home");

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    // TODO : Créer la page d'accueil admin
    $router->get('/', "core#admin");
    $router->get('/menu', "core#menu");
});