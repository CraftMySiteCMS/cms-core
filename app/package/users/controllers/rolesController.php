<?php

namespace CMS\Controller\Roles;

use CMS\Controller\coreController;
use CMS\Model\Roles\rolesModel;

/**
 * Class: @rolesController
 * @package Users
 * @author LoGuardian | CraftMySite <loguardian@hotmail.com>
 * @version 1.0
 */
class rolesController extends coreController
{
    public function adminRolesList(): void
    {
        $rolesModel = new rolesModel();
        $rolesList = $rolesModel->fetchAll();

        view('users', 'roles.list.admin', ["rolesList" => $rolesList], 'admin');
    }
}