<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('PATH_CONFIG', '../app/config/');
define('PATH_MODULES', 'app/modules/');
define('PATH_VIEW', 'resources/views/');
define('PATH_SCRIPTS', 'resources/js/');
define('PATH_VENDOR', 'vendor/');

require_once("../Router/Router.php");
require_once("../Router/Route.php");
require_once("../Router/RouterException.php");

use CMS\Router\Router;
use CMS\Router\RouterException;

require_once("App/__controller.php");
require_once("App/__model.php");

require_once('resources/lang/fr.php');


$router = new Router($_GET['url']);

/* Pages simples */
$router->get('/', function(){ newsController::news_list(); });

try {
    $router->listen();
}
catch (RouterException $e) {
    echo $e->getMessage();
}