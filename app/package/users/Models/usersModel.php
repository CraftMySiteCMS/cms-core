<?php

namespace CMS\Model\users;

use CMS\Model\Manager;

class usersModel extends Manager {
    public $user_id;
    public $user_email;
    public $user_pseudo;
    public $user_firstname; // Prénom
    public $user_lastname; // Nom
    private $user_password;
    public $user_state;
    public $role_id;
    public $user_role_name;
    private $user_key;
    public $user_created;
    public $user_updated;

    public function __construct($user_id = null) {

    }

    public static function getLogedUser(): int {
        if(isset($_SESSION['cms_user_id'])){
            return $_SESSION['cms_user_id'];
        } else {
            return -1;
        }
    }

    public function createUser($user) {

    }
    public function updateUser_infos($user) {

    }
    public function updateUser_password($user) {

    }
    public function deleteUser($user) {

    }
    public function fetch($user_id) {
        $var = array(
            "user_id" => $user_id
        );

        $sql = "SELECT user_id, user_email, user_pseudo, user_firstname, user_lastname, user_state, cms_users.role_id, DATE_FORMAT(user_created, '%d/%m/%Y à %H:%i:%s') AS 'user_created', DATE_FORMAT(user_updated, '%d/%m/%Y à %H:%i:%s') AS 'user_updated', cr.role_name as user_role_name FROM cms_users INNER JOIN cms_roles cr on cms_users.role_id = cr.role_id WHERE user_id=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) {
            $result = $req->fetch();
            foreach ($result as $key => $property) {
                if(property_exists(usersModel::class, $key)) {
                    $this->$key = $property;
                }
            }
        }
    }
    public function fetchAll() {
        $sql = "SELECT user_id, user_email, user_pseudo, user_firstname, user_lastname, user_state, DATE_FORMAT(user_created, '%d/%m/%Y à %H:%i:%s') AS 'user_created', DATE_FORMAT(user_updated, '%d/%m/%Y à %H:%i:%s') AS 'user_updated', cr.role_name as user_role_name FROM cms_users INNER JOIN cms_roles cr on cms_users.role_id = cr.role_id";
        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute();

        if($req) {
            return $req->fetchAll();
        }
    }
    public static function logIn($info, $cookie = false) {
        $password = $info["password"];
        $var = array(
            "user_email" => $info["email"]
        );
        $sql = "SELECT user_id, role_id, user_password"
            ." FROM cms_users"
            ." WHERE user_state=1"
            ." AND user_email"."=:user_email";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req){
            $result = $req->fetch();
            if($result){
                if(password_verify($password, $result["user_password"])){
                    $id = $result["user_id"];
                    switch ($result["user_role"]) {
                        default:
                            $_SESSION['cms_user_id'] = $id;
                            if($cookie){
                                setcookie('cms_cookies_user_id', $id, time()+60*60*24*30, "/");
                            }
                            break;
                    }
                    return $id;
                } else {
                    return -1; // Mot de passe ne corresponds pas
                }
            } else {
                return -2; // Utilisateur inexistant
            }
        } else {
            return -3; // Erreur SQL
        }
    }
    public function update() {
        $info = array(
            "user_id" => $this->user_id,
            "user_email" => $this->user_email,
            "user_pseudo" =>  mb_strimwidth($this->user_pseudo ,0,255),
            "user_firstname" =>  mb_strimwidth($this->user_firstname,0,255),
            "user_lastname" =>  mb_strimwidth($this->user_lastname,0,255),
            "role_id" =>  $this->role_id
        );

        $sql = "UPDATE cms_users SET "
            ."user_email"."=:user_email,"
            ."user_pseudo"."=:user_pseudo,"
            ."user_firstname"."=:user_firstname,"
            ."user_lastname"."=:user_lastname,"
            ."role_id"."=:role_id"
            ." WHERE "."user_id"."=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($info);

        $this->update_edit_time();
    }
    public function setPassword($password) {
        $this->user_password = $password;
    }
    public function update_pass() {
        $info = array(
            "user_id" => $this->user_id,
            "user_password" => $this->user_password
        );

        $sql = "UPDATE cms_users SET "
            ."user_password"."=:user_password"
            ." WHERE "."user_id"."=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($info);

        $this->update_edit_time();
    }
    public function changeState() {
        $info = array(
            "user_id" => $this->user_id,
            "user_state" => $this->user_state,
        );

        $sql = "UPDATE cms_users SET "
            ."user_state"."=:user_state"
            ." WHERE "."user_id"."=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($info);

        $this->update_edit_time();
    }
    public function delete() {
        $info = array(
            "user_id" => $this->user_id,
        );
        $sql = "DELETE"
        ." FROM cms_users"
        ." WHERE user_id=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($info);
    }
    public static function logout() {
        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        session_destroy();
    }

    public function update_edit_time() {
        $info = array(
            "user_id" => $this->user_id,
        );

        $sql = "UPDATE cms_users SET "
            ."user_updated"."=CURRENT_TIMESTAMP"
            ." WHERE "."user_id"."=:user_id";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($info);
    }
}