<?php

use CMS\Router\Router;

require_once('lang/fr.php');

/** @var $router Router Main router */

/* Fronts pages of CMS */
$router->scope('/shop', function($router) {
    $router->get('/', "shop#show");
});

/* Administration scope of package */
$router->scope('/cms-admin/', function($router) {
    $router->get('shop/', 'shop#homeAdmin');

    $router->get('shop/items/', 'shop#listItemsAdmin');
    $router->get('shop/items/add/', 'shop#addItemAdmin');
    $router->post('shop/items/add/', 'shop#addItemPostAdmin');
    $router->post('shop/items/delete/', 'shop#deleteItemPostAdmin');

    $router->get('shop/categories/', 'shop#listCategoriesAdmin');
    $router->get('shop/categories/add/', 'shop#addCategoriesAdmin');
    $router->post('shop/categories/add/', 'shop#addCategoriesPostAdmin');
    $router->post('shop/categories/add/', 'shop#addCategoriesPostAdmin');
    $router->post('shop/categories/delete/', 'shop#deleteCategoriesPostAdmin');
    $router->post('shop/categories/swapItem/', 'shop#swapItemCategoriesPostAdmin');
});