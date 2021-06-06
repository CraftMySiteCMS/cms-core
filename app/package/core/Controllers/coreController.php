<?php

namespace CMS\Controller;

use CMS\Model\coreModel;

class coreController {
    public function home() {
        $core_controller = new coreController();
        $theme_path = $this->cms_theme_path();

        $posts_controller = new namespace\posts\postsController();
        require("$theme_path/views/home.view.php");
    }

    public function admin() {
        require('app/package/core/views/dashboard.admin.view.php');
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
    /* CMS FUNCTION */
    /*
     * Construction du head du CMS
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
     * Construction des mentions légales et des scripts à injecter dans le footer
     */
    public function cms_footer(): string {
        return "<p>Coucou je suis le footer</p>";
    }
    /*
     * Gestion des erreurs
     */
    function cms_errors($error = null) {
        if($error != null) :
            $_SESSION["cms_errors"] = array();
            switch ($error) :
                case 1 :
                    $_SESSION["cms_errors"][] = "Une erreur est survenue, aucune donnée n'a été récuperée. Assurez-vous d'utiliser cette fonction au bon endroit.";
                    break;
                default :
                    $_SESSION["cms_errors"][] = "Une erreur est survenue. Veuillez contacter l'administrateur du site si l'erreur persiste.";
                    break;
            endswitch;
        else :
            $_SESSION["cms_errors"][] = "Une erreur est survenue. Veuillez contacter l'administrateur du site si l'erreur persiste.";
        endif;
    }
    public function cms_errors_display(): string {
        $r = "";
        if(isset($_SESSION["cms_errors"])) :
            $r .= "<div class='errors'>";
            foreach ($_SESSION["cms_errors"] as $error) :
                $r .= "<p>$error</p>";
            endforeach;
            $r .= "</div>";
        endif;
        unset($_SESSION["cms_errors"]);

        return $r;
    }
    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Récupération du menu enregistré en base de données
     */
    public function cms_menu(): array {
        $coreModel = new coreModel();
        $coreModel->fetchMenu();

        return $coreModel->menu;
    }
}

