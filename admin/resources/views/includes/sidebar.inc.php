<?php use CMS\Model\users\usersModel;?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=getenv("PATH_SUBFOLDER")?>cms-admin/" class="brand-link">
        <img src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/images/identity/CraftMySite_Logo.svg" alt="<?=_ALT_LOGO?>" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Craft My Site</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=getenv("PATH_SUBFOLDER")?>admin/resources/images/identity/CraftMySite_Logo.svg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php $user = new usersModel; $user->getUser($_SESSION['cms_user_id']); echo $user->user_pseudo; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php $packages_folder = 'app/package/';
                $scanned_directory = array_diff(scandir($packages_folder), array('..', '.'));
                foreach ($scanned_directory as $package) :
                    $strJsonFileContents = file_get_contents("app/package/$package/infos.json");
                    $package_infos = json_decode($strJsonFileContents, true);
                    if(isset($package_infos["urls_submenu"])) : ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon <?=$package_infos['icon_menu']?>"></i>
                                <p><?=$package_infos['name_menu']?><i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php foreach ($package_infos['urls_submenu'] as $sub_menu_name => $submenu_url) : ?>
                                    <li class="nav-item">
                                        <a href="<?=getenv("PATH_SUBFOLDER")?>cms-admin/<?=$submenu_url?>" class="nav-link">
                                            <p><?=$sub_menu_name?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                    <?php else : ?>
                        <li class="nav-item">
                            <a href="<?=getenv("PATH_SUBFOLDER")?>cms-admin/<?=$package_infos['url_menu']?>" class="nav-link">
                                <i class="nav-icon <?=$package_infos['icon_menu']?>"></i>
                                <p><?=$package_infos['name_menu']?></p>
                            </a>
                        </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>