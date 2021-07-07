<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$path ='../.env';

require_once("../app/EnvBuilder.php");
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

    $host = $_POST['bdd_address'];
    $username = $_POST['bdd_login'];
    $password= $_POST['bdd_pass'];
    $db = $_POST['bdd_name'];
    $subfolder = $_POST['install_folder'];
    $locale = "fr";


    if(file_exists($path)) {
        changeEnvironmentVariable("DB_HOST", $host, $path);
        changeEnvironmentVariable("DB_USERNAME", $username, $path);
        changeEnvironmentVariable("DB_PASSWORD", $password, $path);
        changeEnvironmentVariable("DB_NAME", $db, $path);

        changeEnvironmentVariable("PATH_SUBFOLDER", $subfolder, $path);
        changeEnvironmentVariable("LOCALE", $locale, $path);
    }
    else {
        $env_file = fopen($path, "w") or die("Unable to open file!");

        $txt = "DB_HOST=$host\n";fwrite($env_file, $txt);
        $txt = "DB_USERNAME=$username\n";fwrite($env_file, $txt);
        $txt = "DB_PASSWORD=$password\n";fwrite($env_file, $txt);
        $txt = "DB_NAME=$db\n";fwrite($env_file, $txt);
        $txt = "PATH_ADMIN_VIEW=admin/resources/views/\n";fwrite($env_file, $txt);
        $txt = "PATH_SUBFOLDER=$subfolder\n";fwrite($env_file, $txt);
        $txt = "DEV_MODE=1\n";fwrite($env_file, $txt);
        $txt = "LOCALE=$locale\n";fwrite($env_file, $txt);
        fclose($env_file);
    }

    $db = new PDO("mysql:host=".$_POST['bdd_address'],$_POST['bdd_login'],$_POST['bdd_pass']);
    $db->query("CREATE DATABASE IF NOT EXISTS ".$_POST['bdd_name'].";");
    $db->query("USE ".$_POST['bdd_name'].";");

    $query = file_get_contents("init.sql");
    $stmt = $db->prepare($query);

    $stmt->execute();

    $db = null;

    header('Location: index.php?step=2');
    die();
endif;

/* ADMIN CREATION */
if (isset($_POST['create_admin'])):
    $db = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME')."", getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

    $user_email = $_POST['email'];
    $user_pseudo = $_POST['pseudo'];
    $user_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = $db->prepare('INSERT INTO cms_users (user_email, user_pseudo, user_password, user_state, role_id, user_key, user_created, user_updated) VALUES (:user_email, :user_pseudo, :user_password, :user_state, :role_id, :user_key, NOW(), NOW())');
    $query->execute(array(
        'user_email' => $_POST['email'],
        'user_pseudo' => $_POST['pseudo'],
        'user_password' => $user_password,
        'user_state' => 1,
        'role_id' => 10,
        'user_key' => uniqid()
    ));

    $db = null;

    header('Location: index.php?step=3');
    die();
endif;