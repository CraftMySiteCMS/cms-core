<?php

use CMS\Controller\users\usersController;

require_once('Lang/fr.php');

/* Fronts pages of CMS */
$router->scope('/utilisateurs', function($router) {
    $router->get('/', "users#front_users_list");
    $router->get('/:id-:pseudo', "users#front_users_infos");

    $router->post('/editer', "users#front_users_edit_post");
});

/* Administration scope of package */
$router->scope('/cms-admin', function($router) {
    $router->get('/', "users#admin_login");
    $router->post('/', "users#admin_login_post");

    $router->get('/logout', "users#admin_logout");
});

$router->scope('/cms-admin/users', function($router) {
    $router->get('/list', "users#admin_users_list");

    $router->get('/edit/:id', function($id) {
        (new CMS\Controller\users\usersController)->admin_users_edit($id);
    })->with('id', '[0-9]+');
    $router->post('/edit/:id', function($id) {
        (new CMS\Controller\users\usersController)->admin_users_edit_post($id);
    })->with('id', '[0-9]+');

    $router->get('/add', "users#admin_users_add");
    $router->post('/add', "users#admin_users_add_post");

    $router->post('/edit-state', "users#admin_user_state");
    $router->post('/delete', "users#admin_users_delete");
});