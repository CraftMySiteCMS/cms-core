<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path ='../.env';

require_once("../app/envBuilder.php");
if(file_exists($path)) {
    (new Env($path))->load();
}

/* UPDATE DATABASE */
if (isset($_POST['update_env'])):
    function changeEnvironmentVariable($key,$value,$path) {
        $old = getenv($key);
        file_put_contents($path, str_replace(
            "$key=".$old,
            "$key=".$value,
            file_get_contents($path)
        ));
    }

    $dev = isset($_POST['dev_mode']) ? 1 : 0;

    $host = $_POST['bdd_address'];
    $username = $_POST['bdd_login'];
    $password= $_POST['bdd_pass'];
    $db = $_POST['bdd_name'];
    $subFolder = $_POST['install_folder'];
    $devMode = $dev;
    $locale = $_POST['lang'];
    $timezone = date_default_timezone_get();


    if(file_exists($path)) {
        changeEnvironmentVariable("DB_HOST", $host, $path);
        changeEnvironmentVariable("DB_USERNAME", $username, $path);
        changeEnvironmentVariable("DB_PASSWORD", $password, $path);
        changeEnvironmentVariable("DB_NAME", $db, $path);

        changeEnvironmentVariable("PATH_SUBFOLDER", $subFolder, $path);
        changeEnvironmentVariable("LOCALE", $locale, $path);
        changeEnvironmentVariable("TIMEZONE", $timezone, $path);
    }
    else {
        $envFile = fopen($path, 'wb') or die("Unable to open file!");

        $txt = "DB_HOST=$host\n";fwrite($envFile, $txt);
        $txt = "DB_USERNAME=$username\n";fwrite($envFile, $txt);
        $txt = "DB_PASSWORD=$password\n";fwrite($envFile, $txt);
        $txt = "DB_NAME=$db\n";fwrite($envFile, $txt);
        $txt = "PATH_ADMIN_VIEW=admin/resources/views/\n";fwrite($envFile, $txt);
        $txt = "PATH_SUBFOLDER=$subFolder\n";fwrite($envFile, $txt);
        $txt = "DEV_MODE=$devMode\n";fwrite($envFile, $txt);
        $txt = "LOCALE=$locale\n";fwrite($envFile, $txt);
        $txt = "TIMEZONE=$timezone\n";fwrite($envFile, $txt);
        $txt = "STATUS=0\n";fwrite($envFile, $txt);
        fclose($envFile);
    }

    $db = new PDO("mysql:host=".$_POST['bdd_address'],$_POST['bdd_login'],$_POST['bdd_pass']);
    $db->exec("CREATE DATABASE IF NOT EXISTS ".$_POST['bdd_name'].";");
    $db->exec("USE ".$_POST['bdd_name'].";");



    $query = file_get_contents("init.sql");
    $stmt = $db->query($query);
    $stmt->closeCursor();

    /* IMPORT PACKAGE SQL */
    $packageFolder = '../app/package/';
    $scannedDirectory = array_diff(scandir($packageFolder), array('..', '.'));

    foreach ($scannedDirectory as $package) :
        $packageSqlFile = "../app/package/$package/init.sql";
        if(file_exists($packageSqlFile)) {
            $query_package = file_get_contents($packageSqlFile);
            $stmt_package = $db->prepare($query_package);
            $stmt_package->execute();
            $stmt_package->closeCursor();
            if($devMode === 0) {
                unlink($packageSqlFile);
            }
        }
    endforeach;

    $db = null;

    header('Location: index.php?step=2');
    die();
endif;

/* ADMIN CREATION */
if (isset($_POST['create_admin'])):
    $db = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME')."", getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

    $userEmail = $_POST['email'];
    $userUsername = $_POST['pseudo'];
    $userPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $db->prepare('INSERT INTO cms_users (user_email, user_pseudo, user_password, user_state, role_id, user_key, user_created, user_updated) VALUES (:user_email, :user_pseudo, :user_password, :user_state, :role_id, :user_key, NOW(), NOW())');
    $query->execute(array(
        'user_email' => $_POST['email'],
        'user_pseudo' => $_POST['pseudo'],
        'user_password' => $userPassword,
        'user_state' => 1,
        'role_id' => 10,
        'user_key' => uniqid('', true)
    ));

    $db = null;

    file_put_contents($path, str_replace(
        'STATUS=0', 'STATUS=1', file_get_contents($path)
    ));

    header('Location: index.php?step=3&finish_step');
    die();
endif;
