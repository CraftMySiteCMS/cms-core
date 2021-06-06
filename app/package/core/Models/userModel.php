<?php

namespace CMS\Model;

class UserModel extends Manager {
    public $user_id;
    public $user_email;
    public $user_pseudo;
    public $user_firstname; // Prénom
    public $user_lastname; // Nom
    private $user_password;
    public $user_state;
    public $user_role;
    private $user_key;
    public $user_created;
    public $user_updated;

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
    public function getUser($user_id) {
        $var = array(
            "user_id" => $user_id
        );

        $sql = "SELECT user_id, user_email, user_pseudo, user_firstname, user_lastname, user_state, user_role, DATE_FORMAT(user_created, '%d/%m/%Y à %H:%i:%s') AS 'user_created', DATE_FORMAT(user_updated, '%d/%m/%Y à %H:%i:%s') AS 'user_updated' FROM cms_core_users WHERE user_state = 1 AND user_id=:user_id";

        $db = $this->db_connect();
        $req = $db->prepare($sql);
        $req->execute($var);

        if($req) :
            $result = $req->fetch();
            foreach ($result as $key => $property) :
                if(property_exists(UserModel::class, $key)) :
                    $this->$key = $property;
                endif;
            endforeach;
        endif;
    }
    public function getAllusers() {

    }
    public static function logIn($info, $cookie = false) {
        $password = $info["user_password"];
        $infoSql = array(
            "identifiant" => $info["identifiant"]
        );

        $sql = "SELECT user_id, user_role, user_password"
            ." FROM cms_core_users WHERE user_state=1"
            ." AND (user_email=:identifiant"
            ." OR user_pseudo=:identifiant)";

        $db = Manager::db_connect();
        $req = $db->prepare($sql);
        $req->execute($infoSql);

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
}