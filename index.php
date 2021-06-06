<?php

/* FAUT S'EN PASSER
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') $url = "https://";
else $url = "http://";
$url.= $_SERVER['HTTP_HOST'].'/';

define('WEBSITE_URL', $url);
define('WEBSITE_ADMIN_URL', $url.'admin/');
END */


/* For dev Only, display all warnings and errors */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* End Dev Only */


/* Loading environment variables */
require_once("app/EnvBuilder.php");
(new Env('.env'))->load();

/* Router Initialization */
require_once("Router/Router.php");
use CMS\Router\Router;
require_once("Router/Route.php");
require_once("Router/RouterException.php");
use CMS\Router\RouterException;

/* Router Creation */
if(isset($_GET['url'])) $router = new Router($_GET['url']);
else $router = new Router("");


/* Insert packages */
require_once ("app/config/database.php");
require_once("app/__model.php");
require_once("app/__controller.php");
require_once("app/__routes.php");

/* $router->get('/posts', function(){ echo 'Tous les articles';}); */
/* EXEMPLE - Afficher une page avec plusieurs paramètres
$router->get('/article/:id-:slug', function($id, $slug ) {echo "$id : $slug"; })->with('id', '[0-9]+')->with('slug', '[a-z\-0-9]+');*/

/* Router Display Route */
try {
    $router->listen();
}
catch (RouterException $e) {
    echo $e->getMessage();
}