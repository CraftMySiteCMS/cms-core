<?php

namespace CMS\Controller;

use CMS\Controller\Menus\MenusController;
use CMS\Controller\Users\UsersController;

use CMS\Model\CoreModel;
use JsonException;

/**
 * Class: @CoreController
 * @package Core
 * @author CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class CoreController
{

    public static string $themePath;

    public function __construct($theme_path = null)
    {
        self::$themePath = $this->cmsThemePath();
    }

    /* ADMINISTRATION */
    public function adminDashboard()
    {
        usersController::isAdminLogged();
        require('app/package/core/views/dashboard.admin.view.php');
    }

    /* FRONT */
    public function frontHome()
    {
        $core = new CoreController();
        $menu = new MenusController();

        require(self::$themePath . "/Views/home.view.php");
    }

    private function cmsThemePath(): string
    {
        $coreModel = new CoreModel();
        $coreModel->fetchOption("theme");

        return 'public/themes/' . $coreModel->theme;
    }

    /**
     * @throws JsonException
     */
    public function cmsThemeAvailablePackages(): array
    {
        $jsonFile = file_get_contents($this->cmsThemePath() . "/infos.json");
        return json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR)["packages"];
    }

    /**
     * @throws JsonException
     */
    public function cmsPackageAvailableTheme(string $package): bool
    {
        return in_array($package, $this->cmsThemeAvailablePackages(), true);
    }

    public function cmsPackageInfo(string $package): array
    {
        $jsonFile = file_get_contents("app/package/$package/infos.json");
        return json_decode($jsonFile, true, 512, JSON_THROW_ON_ERROR);
    }

    public function toaster(): string
    {
        $toasters = "";
        if (isset($_SESSION['toaster'])) {
            foreach ($_SESSION['toaster'] as $toaster) {
                $toasterTitle = $toaster['title'];
                $toasterBody = $toaster['body'];
                $toasterClass = $toaster['type'];
                $toasters .= '<script>$(document).Toasts("create", {title: "' . $toasterTitle . '",body: "' . $toasterBody . '",class: "' . $toasterClass . '"});</script>';
            }
            unset($_SESSION['toaster']);
        }
        return $toasters;
    }

    /* //////////////////////////////////////////////////////////////////////////// */
    /* CMS FUNCTION */

    /*
     * Head constructor
     */
    public function cmsHead($title, $description): string
    {
        $head = "<meta charset='utf-8'>";
        $head .= "<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>";
        $head .= "<title>$title</title>";
        $head .= "<meta name='description' content='$description'>";
        $head .= "<meta name='author' content='LoGuardiaN, Teyir, Badiiix, Emilien52'>";
        return $head;
    }

    /*
     * Footer constructor
     */
    public function cmsFooter(): string
    {
        return "<p>Coucou je suis le footer</p>";
    }

    /*
     * Error management
     */
    public static function cmsErrors($error = null): void
    {
        if ($error !== null) :
            $_SESSION["cms_errors"] = array();
            switch ($error) :
                case 1 :
                    $_SESSION["cms_errors"][] = "Une erreur est survenue, aucune donnée n'a été récuperée. Assurez-vous d'utiliser cette fonction au bon endroit.";
                    break;
                case 2 :
                    $_SESSION["cms_errors"][] = "La combinaison email / mot de passe est incorrecte.";
                    break;

                default :
                    $_SESSION["cms_errors"][] = "Une erreur est survenue. Veuillez contacter l'administrateur du site si l'erreur persiste.";
                    break;
            endswitch;
        else :
            $_SESSION["cms_errors"][] = "Une erreur est survenue. Veuillez contacter l'administrateur du site si l'erreur persiste.";
        endif;
    }

    public static function cmsErrorsDisplay(): string
    {
        $r = "";
        if (isset($_SESSION["cms_errors"])) :
            $r .= "<div class='alert alert-danger alert-dismissible'>";
            $r .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
            $r .= "<h5><i class='icon fas fa-info'></i> Information</h5>";
            foreach ($_SESSION["cms_errors"] as $error) :
                $r .= "<p class='m-0'>$error</p>";
            endforeach;
            $r .= "</div>";
        endif;
        unset($_SESSION["cms_errors"]);

        return $r;
    }
}

