<header>
    <nav>
        <ul>
            <?php $menu = $core_controller->CMS_Menu();
            foreach ($menu as $item) :
                echo "<li><a href='$item->menu_url'>$item->menu_name</a></li>";
            endforeach; ?>
        </ul>
    </nav>
    <?= $core_controller->cms_errors_display() ?>
</header>