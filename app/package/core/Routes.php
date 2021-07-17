<?php

use CMS\Router\Router;

require_once('Lang/'.getenv("LOCALE").'.php');

/** @var $router Router Main router */

/* Basics pages of CMS */
$router->get('/',"core#frontHome");

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    $router->get('/dashboard', "core#adminDashboard");
});