<?php

namespace CMS\Model;

class coreModel extends Manager {
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
}