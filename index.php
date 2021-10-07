<?php

/*
 * Warning : This file must NOT be modified !
 */

/* Load installation if empty installation */
if(!file_exists(".env")) {
    header('Location: installation/index.php');
    die();
}

session_start();

/* Loading environment variables */
require_once("app/envBuilder.php");
(new Env('.env'))->load();

/* Display all php errors if dev mode active */
if(getenv("DEV_MODE")) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Loading global lang file */
require_once("admin/resources/lang/" . getenv("LOCALE") . ".php");

/* Insert Global functions */
require_once ("app/tools/builder.php");
require_once ("app/tools/functions.php");

/* Delete installation folder */
if(is_dir("installation") && getenv("DEV_MODE") == 0) {
    deleteDirectory('installation');
}


/* router Initialization */
require_once("router/router.php");
use CMS\Router\router;
require_once("router/route.php");
require_once("router/routerException.php");
use CMS\Router\routerException;

/* router Creation */
if(isset($_GET['url'])) {
    $router = new router($_GET['url']);
}
else {
    $router = new router("");
}

/* Insert all packages */
require_once("app/manager.php");
require_once("app/__model.php");
require_once("app/__controller.php");
require_once("app/__routes.php");

/* router Display route */
try {
    $router->listen();
}
catch (routerException $e) {
    echo $e->getMessage();
}