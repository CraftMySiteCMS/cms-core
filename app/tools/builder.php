<?php

use CMS\Controller\Users\usersController;

function view($module, $view, $data = array(), $type = 'public', $theme = null, $noAdminControl = null){

    extract($data);

    if($type == 'admin'){
        if($noAdminControl == null) {
            usersController::isAdminLogged();
        }

        $path = "app/package/".$module."/views/".$view.".view.php";
        require_once($path);
        require_once(getenv("PATH_ADMIN_VIEW").'template.php');
    }
    else {
        $path = "public/themes/".$theme."/views/".$module."/".$view.".view.php";
        require_once($path);
        require_once("public/themes/".$theme."/views/template.php");
    }
}