<?php

namespace CMS\Model\Menus;

use CMS\Model\manager;

/**
 * Class: @menusModel
 * @package Menus
 * @author LoGuardiaN | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class menusModel extends manager {
    public array $menu;

    /* Get the menu
     *
     */
    public function fetchMenu(): void
    {
        $db = self::dbConnect();
        $req = $db->query('SELECT menu_id, menu_name, menu_url, menu_level, menu_parent_id FROM cms_menus');
        $this->menu = $req->fetchAll(\PDO::FETCH_CLASS);
    }
}
