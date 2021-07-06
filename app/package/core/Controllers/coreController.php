<?php
namespace CMS\Controller;

use CMS\Controller\menus\menusController;
use CMS\Controller\users\usersController;

use CMS\Model\coreModel;

class coreController {

    public static string $theme_path;

    public function __construct($theme_path = null) {
        self::$theme_path = $this->cms_theme_path();
    }

    /* ADMINISTRATION */
    public function admin_dashboard() {
        usersController::is_admin_logged();
        require('app/package/core/views/dashboard.admin.view.php');
    }

    /* FRONT */
    public function front_home() {
        $core = new coreController();
        $menu = new menusController();

        require(self::$theme_path."/Views/home.view.php");
    }

    /* //////////////////////////////////////////////////////////////////////////// */
    /*
     * Get active theme
     */
    private function cms_theme_path(): string {
        $coreModel = new coreModel();
        $coreModel->fetchOption("theme");

        return 'public/themes/'.$coreModel->theme;
    }

    /* //////////////////////////////////////////////////////////////////////////// */
    /*
     * Useful toast generation
     */
    function toaster(): string
    {
        $toasters = "";
        if(isset($_SESSION['toaster'])) {
            foreach ($_SESSION['toaster'] as $toaster) {
                $toaster_title = $toaster['title'];
                $toaster_body = $toaster['body'];
                $toaster_class = $toaster['type'];
                $toasters .= '<script>$(document).Toasts("create", {title: "'.$toaster_title.'",body: "'.$toaster_body.'",class: "'.$toaster_class.'"});</script>';
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
    public function cms_head($title, $description): string {
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
    public function cms_footer(): string {
        return "<p>Coucou je suis le footer</p>";
    }

    /*
     * Error management
     */
    static function cms_errors($error = null) {
        if($error != null) :
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
    static function cms_errors_display(): string {
        $r = "";
        if(isset($_SESSION["cms_errors"])) :
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

