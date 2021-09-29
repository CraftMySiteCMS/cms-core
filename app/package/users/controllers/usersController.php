<?php

namespace CMS\Controller\Users;

use CMS\Controller\coreController;
use CMS\Controller\Menus\menusController;
use CMS\Model\Users\rolesModel;
use CMS\Model\Users\usersModel;

/**
 * Class: @usersController
 * @package Users
 * @author LoGuardian | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class usersController extends coreController
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
        if (usersModel::getLoggedUser() !== -1) {
            $user = new usersModel();
            $user->fetch($_SESSION['cmsUserId']);
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
        if (usersModel::getLoggedUser() !== -1) {
            header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin/dashboard');
        } else {
            $toaster = bigToaster();
            view('users', 'login.admin', ["toaster" => $toaster], 'admin', 1);
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
        $userId = usersModel::logIn($infos, $cookie);
        if ($userId > 0 && $userId !== "ERROR") {
            $user = new usersModel();
            $user->userId = $userId;
            $user->updateLoggedTime();
            header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin/dashboard');
        } else {
            $_SESSION['toaster'][0]['title'] = "Désolé";
            $_SESSION['toaster'][0]['body'] = "Cette combinaison email/mot de passe est erronée";
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function adminLogOut(): void
    {
        usersModel::logout();
        header('Location: ' . getenv('PATH_SUBFOLDER') . 'cms-admin');
    }

    public function adminUsersList(): void
    {
        $userModel = new usersModel();
        $userList = $userModel->fetchAll();

        view('users', 'list.admin', ["userList" => $userList], 'admin');
    }

    public function adminUsersEdit($id): void
    {
        $user = new usersModel();
        $user->fetch($id);

        $roles = new rolesModel();
        $roles = $roles->fetchAll();

        $toaster = bigToaster();

        view('users', 'user.admin', ["user" => $user, "roles" => $roles, "toaster" => $toaster], 'admin');
    }

    public function adminUsersEditPost($id): void
    {
        self::isAdminLogged();

        $user = new usersModel();
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
        $roles = new rolesModel();
        $roles = $roles->fetchAll();

        view('users', 'add.admin', ["roles" => $roles], 'admin');
    }

    public function adminUsersAddPost(): void
    {
        self::isAdminLogged();

        $user = new usersModel();
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

        if (usersModel::getLoggedUser() == $_POST['id']) {
            $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = USERS_STATE_TOASTER_ERROR;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $state = ($_POST['actual_state']) ? 0 : 1;

        $user = new usersModel();
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

        if (usersModel::getLoggedUser() == $_POST['id']) {
            $_SESSION['toaster'][0]['title'] = USERS_TOASTER_TITLE_ERROR;
            $_SESSION['toaster'][0]['type'] = "bg-danger";
            $_SESSION['toaster'][0]['body'] = USERS_DELETE_TOASTER_ERROR;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }

        $user = new usersModel();
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
        $core = new coreController();
        $menu = new menusController();

        view('users', 'users_infos', ["core" => $core, "menu" => $menu], 'public');
    }
}