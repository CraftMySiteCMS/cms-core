<?php

use CMS\Controller\users\usersController;
use CMS\Router\router;

require_once('Lang/'.getenv("LOCALE").'.php');

/** @var $router router Main router */

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    $router->get('/', "users#adminLogin");
    $router->post('/', "users#adminLoginPost");

    $router->get('/logout', "users#adminLogout");
});

$router->scope('/cms-admin/users', function($router) {
    $router->get('/list', "users#adminUsersList");

    $router->get('/edit/:id', function($id) {
        (new usersController)->adminUsersEdit($id);
    })->with('id', '[0-9]+');
    $router->post('/edit/:id', function($id) {
        (new usersController)->adminUsersEditPost($id);
    })->with('id', '[0-9]+');

    $router->get('/add', "users#adminUsersAdd");
    $router->post('/add', "users#adminUsersAddPost");

    $router->post('/edit-state', "users#adminUserState");
    $router->post('/delete', "users#adminUsersDelete");
});

$router->scope('/cms-admin/roles', function($router) {
    $router->get('/list', "roles#adminRolesList");
});