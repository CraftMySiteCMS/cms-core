<?php

namespace CMS\Model;

class CoreModel extends Manager {
    var $theme;
    var $menu;

    /* Récupère la valeur d'une option selon son nom
     * $option : string
     */
    public function fetchOption($option) {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT option_value FROM cms_core_options WHERE option_name = ?');
        $req->execute(array($option));
        $option = $req->fetch();

        $this->theme = $option['option_value'];
    }
    /* Met à jour l'option demandée
     * $option_infos : array("option_value" => "value", "option_name" => "name")
     */
    public function updateOption($option_infos) {
        $db = $this->db_connect();
        $req = $db->prepare('UPDATE cms_core_options SET option_value=:option_value, option_updated=now() WHERE option_name=:option_name');
        $req->execute($option_infos);
    }
    /* Récupère le menu
     *
     */
    public function fetchMenu() {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT menu_id, menu_name, menu_url, menu_level, menu_parent_id FROM cms_core_menu');
        $req->execute();
        $this->menu = $req->fetchAll(\PDO::FETCH_CLASS);
    }
}