<?php
namespace CMS\Controller\users;

use CMS\Controller\coreController;
use CMS\Controller\menus\menusController;
use CMS\Model\users\usersModel;

session_start();

class usersController extends coreController {
    /* //////////////////////////////////////////////////////////////////////////// */
    /*
     * If is admin logged
     */
    static function is_admin_logged() {
        if(usersModel::getLogedUser() != -1) {
            $user = new usersModel();
            $user->getUser($_SESSION['cms_user_id']);
            if($user->user_role != 10) {
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
        if($_POST['login_keep_connect']){
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
    }
    public function admin_users_edit() {
        $this->is_admin_logged();
    }
    public function admin_users_edit_post() {
        $this->is_admin_logged();
    }
    public function admin_users_add() {
        $this->is_admin_logged();
    }
    public function admin_users_add_post() {
        $this->is_admin_logged();
    }
    public function admin_users_delete() {
        $this->is_admin_logged();
    }

    /* FRONT */
    public function front_users_list() {
        $core = new coreController();
        $menu = new menusController();

        require(coreController::$theme_path."/Views/users/users_infos.view.php");
    }
}