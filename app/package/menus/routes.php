<?php

use CMS\Router\router;

require_once('Lang/'.getenv("LOCALE").'.php');

/** @var $router router Main router */


/* Administration scope of package */
$router->scope('/cms-admin/menus', function($router) {
    $router->get('/', "menus#adminMenus");
});