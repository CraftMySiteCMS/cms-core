<?php use CMS\Controller\coreController; ?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>

    <?= $core->cmsHead($title, $description) ?>

    <!-- Theme style -->
    <link rel="stylesheet" type="text/css"
          href="<?= getenv("PATH_SUBFOLDER") ?>public/themes/Sampler/assets/css/main.css">
</head>
<body>
    <?= $core->cmsSWarn() ?>