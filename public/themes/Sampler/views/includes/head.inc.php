<?php use CMS\Controller\CoreController; ?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>

    <?= /** @var CoreController $core
     * @var string $title
     * @var string $description
     */
    $core->cms_head($title, $description) ?>

    <!-- Theme style -->
    <link rel="stylesheet" type="text/css"
          href="<?= getenv("PATH_SUBFOLDER") ?>public/themes/Sampler/assets/css/main.css">
</head>
<body>