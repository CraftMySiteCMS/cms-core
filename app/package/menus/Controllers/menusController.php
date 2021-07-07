<?php

namespace CMS\Controller\menus;

use CMS\Controller\coreController;
use CMS\Model\menus\menusModel;

class menusController extends coreController {
    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Retrieving the menu saved in the database
     */
    public function cms_menu(): array
    {
        $coreModel = new menusModel();
        $coreModel->fetchMenu();

        return $coreModel->menu;
    }
}