<?php

namespace CMS\Model\users;

use CMS\Model\Manager;

class rolesModel extends Manager {
    public $role_id;
    public $role_name;

    public function fetchAll() {
        $sql = "SELECT role_id, role_name FROM cms_roles";
        $db = Manager::db_connect();
        $req = $db->prepare($sql);

        if($req->execute()) {
            return $req->fetchAll();
        }
    }

}
