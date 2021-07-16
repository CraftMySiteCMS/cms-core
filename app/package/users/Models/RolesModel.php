<?php

namespace CMS\Model\Users;

use CMS\Model\Manager;

/**
 * Class: @RolesModel
 * @package Users
 * @author LoGuardian | CraftMySite <contact@craftmysite.fr>
 * @version 1.0
 */
class RolesModel extends Manager {
    public int $roleId;
    public string $roleName;

    public function fetchAll(): array
    {
        $sql = "SELECT role_id, role_name FROM cms_roles";
        $db = Manager::dbConnect();
        $req = $db->prepare($sql);

        if($req->execute()) {
            return $req->fetchAll();
        }

        return [];
    }

}
