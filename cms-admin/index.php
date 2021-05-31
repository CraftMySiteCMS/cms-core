<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define('PATH_CONFIG', '../app/config/');
define('PATH_MODULES', 'app/modules/');

define('PATH_VIEW', 'resources/views/');
define('PATH_SCRIPTS', 'resources/js/');

define('PATH_VENDOR', 'vendor/');

use CMS\Router\RouterException;

require_once('resources/lang/fr.php');

require_once("../Router/Router.php");
require_once("../Router/Route.php");
require_once("../Router/RouterException.php");

require('app/__controller.php');
require('app/__model.php');

$router = new CMS\Router\Router($_GET['url']);
$router->get('/', function(){ NewsController::news_list(); });

try {
    $router->run();
}
catch (RouterException $e) {}