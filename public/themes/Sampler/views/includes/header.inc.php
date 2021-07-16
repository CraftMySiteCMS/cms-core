<?php use CMS\Controller\Menus\MenusController;
use CMS\Controller\CoreController; ?>

<header>
    <nav>
        <ul>
            <?php
            /** @var MenusController $menu */

            $menu = $menu->cmsMenu();
            foreach ($menu as $item) :
                echo "<li><a href='$item->menu_url'>$item->menu_name</a></li>";
            endforeach; ?>
        </ul>
    </nav>
    <?= /** @var CoreController $core */
    $core->cmsErrorsDisplay() ?>
</header>