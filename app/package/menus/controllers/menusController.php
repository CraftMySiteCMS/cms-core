<?php

namespace CMS\Controller\Menus;

use CMS\Controller\coreController;
use CMS\Model\Menus\menusModel;

/**
 * Class: @menusController
 * @package Menus
 * @author LoGuardiaN | CraftMySite <loguardian@hotmail.com>
 * @version 1.0
 */
class menusController extends coreController {
    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Retrieving the menu saved in the database
     */
    public function cmsMenu(): array
    {
        $coreModel = new menusModel();
        $coreModel->fetchMenu();

        return $coreModel->menu;
    }

    public function adminMenus() {
        view('menus', 'menus.admin', [], 'admin');
    }
}