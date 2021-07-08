<?php

use CMS\Controller\pages\pagesController;

require_once('Lang/'.getenv("LOCALE").'.php');

/* Fronts pages of CMS */

/* Administration scope of package */
$router->scope('/cms-admin/pages', function($router) {
    $router->get('/list', "pages#admin_pages_list");

    $router->get('/edit/:id', function($id) {
        (new CMS\Controller\pages\pagesController)->admin_pages_edit($id);
    })->with('id', '[0-9]+');
    $router->post('/edit', "pages#admin_pages_edit_post");

    $router->get('/add', "pages#admin_pages_add");
    $router->post('/add', "pages#admin_pages_add_post");

    $router->post('/edit-state', "pages#admin_user_state");
    $router->post('/delete', "pages#admin_pages_delete");
});