<?php

namespace CMS\Controller\Menus;

use CMS\Controller\CoreController;
use CMS\Model\Menus\MenusModel;

/**
 * Class: @MenusController
 * @package Menus
 * @author LoGuardiaN | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class MenusController extends CoreController {
    /* //////////////////////////////////////////////////////////////////////////// */
    /* GLOBALS FUNCTIONS */
    /*
     * Retrieving the menu saved in the database
     */
    public function cmsMenu(): array
    {
        $coreModel = new MenusModel();
        $coreModel->fetchMenu();

        return $coreModel->menu;
    }

    public function adminMenus() {
        require('app/package/menus/views/menus.admin.view.php');
    }
}