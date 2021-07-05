<?php
require_once('Lang/fr.php');

/* Basics pages of CMS */
$router->get('/',"core#front_home");

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    $router->get('/dashboard', "core#admin_dashboard");
});