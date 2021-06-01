<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?=WEBSITE_ADMIN_URL?>resources/images/identity/CraftMySite_Logo.svg" alt="<?=_ALT_LOGO?>" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Craft My Site</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=WEBSITE_ADMIN_URL?>resources/images/identity/CraftMySite_Logo.svg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">LoGuardiaN</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php $packages_folder = 'app/package/';
                $scanned_directory = array_diff(scandir($packages_folder), array('..', '.'));
                foreach ($scanned_directory as $package) :
                    $strJsonFileContents = file_get_contents("app/package/$package/infos.json");
                    $array = json_decode($strJsonFileContents, true); ?>
                    <li class="nav-item">
                        <a href="<?=WEBSITE_ADMIN_URL?><?=$array['url_menu']?>" class="nav-link">
                            <i class="nav-icon <?=$array['icon_menu']?>"></i>
                            <p><?=$array['name_menu']?></p>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>