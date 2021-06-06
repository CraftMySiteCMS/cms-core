<?php

/*
 * Warning : This file must not be modified !
 */

/* Loading environment variables */
require_once("app/EnvBuilder.php");
(new Env('.env'))->load();

if(getenv("DEV_MODE")) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Router Initialization */
require_once("Router/Router.php");
use CMS\Router\Router;
require_once("Router/Route.php");
require_once("Router/RouterException.php");
use CMS\Router\RouterException;

/* Router Creation */
if(isset($_GET['url'])) $router = new Router($_GET['url']);
else $router = new Router("");

/* Insert all packages */
require_once ("app/config/Manager.php");
require_once("app/__model.php");
require_once("app/__controller.php");
require_once("app/__routes.php");

/* Router Display Route */
try {
    $router->listen();
}
catch (RouterException $e) {
    echo $e->getMessage();
}