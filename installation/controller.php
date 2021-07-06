<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../app/EnvBuilder.php");
(new Env('../.env'))->load();

/* UPDATE DATABASE */
if (isset($_POST['update_env'])):
    function changeEnvironmentVariable($key,$value) {
        $path ='../.env';
        $old = getenv($key);
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                "$key=".$old,
                "$key=".$value,
                file_get_contents($path)
            ));
        }
    }

    changeEnvironmentVariable("DB_HOST", $_POST['bdd_address']);
    changeEnvironmentVariable("DB_USERNAME", $_POST['bdd_login']);
    changeEnvironmentVariable("DB_PASSWORD", $_POST['bdd_pass']);
    changeEnvironmentVariable("DB_NAME", $_POST['bdd_name']);

    changeEnvironmentVariable("PATH_SUBFOLDER", $_POST['install_folder']);


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