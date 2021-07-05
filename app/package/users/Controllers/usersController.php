<?php
namespace CMS\Controller\users;

use CMS\Controller\coreController;
use CMS\Controller\menus\menusController;
use CMS\Model\users\rolesModel;
use CMS\Model\users\usersModel;

session_start();

class usersController extends coreController {

    public static string $theme_path;

    public function __construct($theme_path = null) {
        parent::__construct($theme_path);
    }

    /* //////////////////////////////////////////////////////////////////////////// */
    /*
     * If is admin logged
     */
    static function is_admin_logged() {
        if(usersModel::getLogedUser() != -1) {
            $user = new usersModel();
            $user->fetch($_SESSION['cms_user_id']);
            if($user->role_id != 10) {
                header('Location: '.getenv('PATH_SUBFOLDER'));
                exit();
            }
        }
        else {
            header('Location: '.getenv('PATH_SUBFOLDER'));
            exit();
        }
    }

    /* ADMINISTRATION */
    public function admin_login() {
        if(usersModel::getLogedUser() != -1) header('Location: '.getenv('PATH_SUBFOLDER').'cms-admin/dashboard');
        else require('app/package/users/Views/login.admin.view.php');
    }
    public function admin_login_post() {
        $infos = array(
            "email" => $_POST['login_email'],
            "password" => $_POST['login_password']
        );
        $cookie = 0;
        if(isset($_POST['login_keep_connect']) && $_POST['login_keep_connect']){
            $cookie = 1;
        }
        $userId = usersModel::logIn($infos, $cookie);
        if($userId>0 && $userId != "ERROR"){
            header('Location: '.getenv('PATH_SUBFOLDER').'cms-admin/dashboard');
        } else {
            coreController::cms_errors(2);
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    public function admin_logout() {
        usersModel::logout();
        header('Location: '.getenv('PATH_SUBFOLDER').'cms-admin');
    }

    public function admin_users_list() {
        $this->is_admin_logged();

        $usersModel = new usersModel();
        $users_list = $usersModel->fetchAll();

        require('app/package/users/views/list.admin.view.php');
    }
    public function admin_users_edit($id) {
        $this->is_admin_logged();
        $user = new usersModel();
        $user->fetch($id);

        $roles = new rolesModel();
        $roles = $roles->fetchAll();

        $toaster = $this->toaster();

        require('app/package/users/views/user.admin.view.php');
    }
    public function admin_users_edit_post($id) {
        $this->is_admin_logged();

        $user_id = $id;
        $user_email = $_POST['email'];
        $user_pseudo = $_POST['pseudo'];
        $user_firstname = $_POST['name'];
        $user_lastname = $_POST['lastname'];
        $role_id = $_POST['role'];

        $user = new usersModel();
        $user->user_id = $user_id;
        $user->user_email = $user_email;
        $user->user_pseudo = $user_pseudo;
        $user->user_firstname = $user_firstname;
        $user->user_lastname = $user_lastname;
        $user->role_id = $role_id;
        $user->update();

        if(!empty($_POST['pass']) && $_POST['pass'] === $_POST['pass_verif']) {
            $user->setPassword(password_hash($_POST['pass'], PASSWORD_BCRYPT));
            $user->update_pass();
        }

        header("location: ../edit/".$user_id);
        die();
    }
    public function admin_users_add() {
        $this->is_admin_logged();
    }
    public function admin_users_add_post() {
        $this->is_admin_logged();
    }
    public function admin_user_state() {
        $this->is_admin_logged();

        $state = ($_POST['actual_state']) ? 0 : 1;

        $user = new usersModel();
        $user->user_id = $_POST['id'];
        $user->user_state = $state;
        $user->changeState();

        $_SESSION['toaster'][0]['title'] = "Information";
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = "Le compte a bien été modifié";

        header("location: ".$_SERVER['HTTP_REFERER']);
        die();
    }
    public function admin_users_delete() {
        $this->is_admin_logged();

        $user = new usersModel();
        $user->user_id = $_POST['id'];
        $user->delete();

        $_SESSION['toaster']['title'] = "Information";
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster']['body'] = "Le compte a bien été supprimé";
        header("location: ../");
        die();
    }

    /* FRONT */
    public function front_users_list() {
        $core = new coreController();
        $menu = new menusController();

        require(self::$theme_path."/Views/users/users_infos.view.php");
    }
}