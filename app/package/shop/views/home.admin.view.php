<?php

$title = SHOP_MAIN_TITLE;
$description = SHOP_MAIN_DESCRIPTION;
ob_start();
?>


<?php
/**
 * @var $initErrors array \CMS\Model\shop\shopModel missedTables function.
 */
if (count($initErrors) > 0) : ?>

    <div class="container">
        <div class="alert alert-danger" role="alert">

            <p><?= SHOP_ERROR_INIT ?></p>

            <ul>
                <?php foreach ($initErrors as $iError) : ?>

                    <li><?= $iError ?></li>

                <?php endforeach; ?>
            </ul>
        </div>
    </div>

<?php endif ?>


<?php $content = ob_get_clean();
require(getenv('PATH_ADMIN_VIEW') . 'template.php'); ?>