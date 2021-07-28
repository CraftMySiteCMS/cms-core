<?php

use CMS\Controller\pages\pagesController;
use CMS\Router\Router;

require_once('Lang/' . getenv("LOCALE") . '.php');

/** @var $router Router Main router */

/* Fronts pages of CMS */

/* Administration scope of package */
$router->scope('/cms-admin/pages', function ($router) {
    $router->get('/list', "pages#adminPagesList");

    $router->get('/edit/:id', function ($id) {
        (new pagesController)->adminPagesEdit($id);
    })->with('id', '[0-9]+');
    $router->post('/edit', "pages#adminPagesEditPost");

    $router->get('/add', "pages#adminPagesAdd");
    $router->post('/add', "pages#adminPagesAddPost");

    $router->post('/edit-state', "pages#adminUserState");
    $router->post('/delete', "pages#adminPagesDelete");
});