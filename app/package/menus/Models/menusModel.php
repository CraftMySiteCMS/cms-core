<?php

namespace CMS\Model;

class menusModel extends Manager {
    var $menu;

    /* Get the menu
     *
     */
    public function fetchMenu() {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT menu_id, menu_name, menu_url, menu_level, menu_parent_id FROM cms_core_menu');
        $req->execute();
        $this->menu = $req->fetchAll(\PDO::FETCH_CLASS);
    }
}
