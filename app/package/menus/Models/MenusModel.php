<?php

namespace CMS\Model\Menus;

use CMS\Model\Manager;

/**
 * Class: @MenusModel
 * @package Menus
 * @author LoGuardiaN | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class MenusModel extends Manager {
    public array $menu;

    /* Get the menu
     *
     */
    public function fetchMenu(): void
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT menu_id, menu_name, menu_url, menu_level, menu_parent_id FROM cms_core_menu');
        $this->menu = $req->fetchAll(\PDO::FETCH_CLASS);
    }
}
