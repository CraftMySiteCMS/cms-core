<?php

namespace CMS\Model\Roles;

use CMS\Model\manager;

/**
 * Class: @rolesModel
 * @package Users
 * @author LoGuardian | CraftMySite <loguardian@hotmail.com>
 * @version 1.0
 */
class rolesModel extends manager {
    public int $roleId;
    public string $roleName;

    public function fetchAll(): array
    {
        $sql = "SELECT role_id, role_name FROM cms_roles";
        $db = manager::dbConnect();
        $req = $db->prepare($sql);

        if($req->execute()) {
            return $req->fetchAll();
        }

        return [];
    }

}
