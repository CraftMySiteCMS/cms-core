<?php

namespace CMS\Model;

/**
 * Class: @CoreModel
 * @package Core
 * @author CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class CoreModel extends Manager
{
    public string $theme;
    public array $menu;

    public function fetchOption($option): void
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT option_value FROM cms_core_options WHERE option_name = ?');
        $req->execute(array($option));
        $option = $req->fetch();

        $this->theme = $option['option_value'];
    }

    public function updateOption($option_infos): void
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE cms_core_options SET option_value=:option_value, option_updated=now() WHERE option_name=:option_name');
        $req->execute($option_infos);
    }
}