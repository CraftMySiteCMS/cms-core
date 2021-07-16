<?php

namespace CMS\Controller\Users;

use CMS\Controller\CoreController;
use CMS\Controller\Menus\MenusController;
use CMS\Model\Users\RolesModel;
use CMS\Model\Users\UsersModel;

session_start();

/**
 * Class: @UsersController
 * @package Users
 * @author LoGuardian | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class UsersController extends CoreController
{

    public static string $themePath;

    public function __construct($theme_path = null)
    {
        parent::__construct($theme_path);
    }

    /* //////////////////////////////////////////////////////////////////////////// */
    /*
     * If is admin logged
     */
    public static function isAdminLogged(): void
    {
        if (UsersModel::getLoggedUser() !== -1) {
            $user = new UsersModel();
            $user->fetch($_SESSION['cms_user_id']);
            if ($user->roleId !== 10) {
                header('Location: ' . getenv('PATH_SUBFOLDER'));
                exit();
            }
        } else {
            header('Location: ' . getenv('PATH_SUBFOLDER'));
            exit();
        }
    }

    /* ADMINISTRATION */
    public function adminLogin(): void
    {
        if (UsersModel::getLoggedUser() !== -1) {
            header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin/dashboard');
        } else {
            require('app/package/users/Views/login.admin.view.php');
        }
    }

    public function adminLoginPost(): void
    {
        $infos = array(
            "email" => $_POST['login_email'],
            "password" => $_POST['login_password']
        );
        $cookie = 0;
        if (isset($_POST['login_keep_connect']) && $_POST['login_keep_connect']) {
            $cookie = 1;
        }
        $userId = UsersModel::logIn($infos, $cookie);
        if ($userId > 0 && $userId !== "ERROR") {
            $user = new UsersModel();
            $user->userId = $userId;
            $user->updateLoggedTime();
            header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin/dashboard');
        } else {
            CoreController::cmsErrors(2);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function adminLogOut(): void
    {
        UsersModel::logout();
        header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin');
    }

    public function adminUsersList(): void
    {
        self::isAdminLogged();

        $userModel = new UsersModel();
        $userList = $userModel->fetchAll();

        require('app/package/users/views/list.admin.view.php');
    }

    public function adminUsersEdit($id): void
    {
        self::isAdminLogged();
        $user = new UsersModel();
        $user->fetch($id);

        $roles = new RolesModel();
        $roles = $roles->fetchAll();

        $toaster = $this->toaster();

        require('app/package/users/views/user.admin.view.php');
    }

    public function adminUsersEditPost($id): void
    {
        self::isAdminLogged();

        $user = new UsersModel();
        $user->userId = $id;
        $user->userEmail = $_POST['email'];
        $user->userPseudo = $_POST['pseudo'];
        $user->userFirstname = $_POST['name'];
        $user->userLastname = $_POST['lastname'];
        $user->roleId = $_POST['role'];
        $user->update();

        $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = USERS_EDIT_TOASTER_SUCCESS;

        if (!empty($_POST['pass'])) {
            if ($_POST['pass'] === $_POST['pass_verif']) {
                $user->setPassword(password_hash($_POST['pass'], PASSWORD_BCRYPT));
                $user->updatePass();
            } else {
                $_SESSION['toaster'][1]['title'] = USERS_TOASTER_TITLE_ERROR;
                $_SESSION['toaster'][1]['type'] = "bg-danger";
                $_SESSION['toaster'][1]['body'] = USERS_EDIT_TOASTER_PASS_ERROR;
            }

        }

        header("location: ../edit/" . $id);
        die();
    }

    public function adminUsersAdd(): void
    {
        self::isAdminLogged();

        $roles = new RolesModel();
        $roles = $roles->fetchAll();

        require('app/package/users/views/add.admin.view.php');
    }

    public function adminUsersAddPost(): void
    {
        self::isAdminLogged();

        $user = new UsersModel();
        $user->userEmail = $_POST['email'];
        $user->userPseudo = $_POST['pseudo'];
        $user->userFirstname = $_POST['name'];
        $user->userLastname = $_POST['lastname'];
        $user->roleId = $_POST['role'];
        $user->create();

        $user->setPassword(password_hash($_POST['pass'], PASSWORD_BCRYPT));
        $user->updatePass();

        header("location: ../users/list");
    }

    public function adminUserState(): void
    {
        self::isAdminLogged();

        if (UsersModel::getLoggedUser() === $_POST['id']) {
            $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = USERS_STATE_TOASTER_ERROR;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $state = ($_POST['actual_state']) ? 0 : 1;

        $user = new UsersModel();
        $user->userId = $_POST['id'];
        $user->userState = $state;
        $user->changeState();

        $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = USERS_STATE_TOASTER_SUCCESS;

        header("location: " . $_SERVER['HTTP_REFERER']);
        die();
    }

    public function adminUsersDelete(): void
    {
        self::isAdminLogged();

        if (UsersModel::getLoggedUser() === $_POST['id']) {
            $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = USERS_DELETE_TOASTER_ERROR;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $user = new UsersModel();
        $user->userId = $_POST['id'];
        $user->delete();

        $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE;
        $_SESSION['toaster'][0]['type'] = "bg-success";
        $_SESSION['toaster'][0]['body'] = USERS_DELETE_TOASTER_SUCCESS;
        header("location: ../");
        die();
    }

    /* FRONT */
    public function frontUserList(): void
    {
        $core = new CoreController();
        $menu = new MenusController();

        require(self::$themePath . "/Views/users/users_infos.view.php");
    }
}