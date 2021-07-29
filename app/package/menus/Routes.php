<?php

use CMS\Router\Router;

require_once('Lang/'.getenv("LOCALE").'.php');

/** @var $router Router Main router */


/* Administration scope of package */
$router->scope('/cms-admin/menus', function($router) {
    $router->get('/', "menus#adminMenus");
});