<?php use CMS\Controller\Menus\menusController;
use CMS\Controller\coreController; ?>

<header>
    <nav>
        <ul>
            <?php
            /** @var menusController $menu */

            $menu = $menu->cmsMenu();
            foreach ($menu as $item) :
                echo "<li><a href='$item->menu_url'>$item->menu_name</a></li>";
            endforeach; ?>
        </ul>
    </nav>
</header>