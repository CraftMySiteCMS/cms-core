<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('PATH_CONFIG', 'app/config/');
define('PATH_CONTROLLER', 'app/controller/');
define('PATH_MODEL', 'app/model/');
define('PATH_VIEW', 'resources/views/');
define('PATH_SCRIPTS', 'resources/js/');
define('PATH_VENDOR', 'vendor/');

/** Start Controller **/
require_once('resources/lang/fr.php');
require_once('app/routes.php');